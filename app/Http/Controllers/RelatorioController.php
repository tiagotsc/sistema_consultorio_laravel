<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Relatorio;
use App\RelatorioCategoria;
use App\RelatorioCampo;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RelatorioController extends Controller
{
    # Apelidos para conexões (Usado para executar a query em determinado banco de dados)
    private $bancosDeDados = array(
                                    'mysql'=>'Mysql Conexão padrão',
                                );
    
    function __construct()
    { 
            $this->middleware('permission:relatorio-visualizar',['only' => ['index']]);
            $this->middleware('permission:relatorio-gerenciar',['only' => ['gerenciar']]);
            $this->middleware('permission:relatorio-cadastrar', ['only' => ['create','store']]);
            $this->middleware('permission:relatorio-editar', ['only' => ['edit','update']]);
            $this->middleware('permission:relatorio-excluir',['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfisId = Auth::user()->roles->pluck('id')->toArray();
        $perfilPermissions = DB::table('role_has_permissions')->whereIn('role_id', $perfisId)->pluck('permission_id')->toArray();
        $userPermissions = Auth::user()->permissions->pluck('id')->toArray();

        $permissioesUsuario = array_merge($perfilPermissions,$userPermissions);

        $categorias = RelatorioCategoria::where('status','A')->whereHas('relatorios', function ($query) use($permissioesUsuario) {
            $query->where('relatorios.status','A')->whereIn('relatorios.permission_id',$permissioesUsuario)->orderBy('nome');
        })->orderBy('nome')->get();
        return view("relatorio.index",['categorias' => $categorias, 'permissioesUsuario' => $permissioesUsuario]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bancosDeDados = $this->bancosDeDados;
        $categorias = RelatorioCategoria::where('status','A')->orderBy('nome')->pluck('nome','id')->prepend('Selecione...','');
        $campos = RelatorioCampo::where('status','A')->get();
        $perfis = Role::orderBy('name')->get();
        return view("relatorio.create",[
                        'categorias'=>$categorias,
                        'campos'=>$campos,
                        'bancosDeDados'=>$bancosDeDados, 
                        'perfis' => $perfis
                        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $categoria = RelatorioCategoria::find($request->input('relatorio_categoria_id'));
            $dadosPermissao['name'] = 'Relatório_Criado.'.$request->input('nome').' | '.$categoria->nome;
            $dadosPermissao['guard_name'] = 'web';
            $permissao = Permission::create($dadosPermissao);
            $perfisMarcados = $request->input('perfis');
            if($perfisMarcados != null){
                foreach($perfisMarcados as $perfilId){
                    $perfil = Role::find($perfilId);
                    $perfil->givePermissionTo($permissao);
                }
            }

            $dados['nome'] = $request->input('nome');
            $dados['descricao'] = $request->input('descricao');
            $dados['query'] = $request->input('query');
            $dados['relatorio_categoria_id'] = $request->input('relatorio_categoria_id');
            $dados['permission_id'] = $permissao->id;
            $dados['banco_conexao'] = $request->input('banco_conexao');
            $dados['status'] = $request->input('status');

            $relatorio = Relatorio::create($dados);

            $campoMarcado = $request->input('campo');
            $campoNome = $request->input('campo_nome');
            $campoLegenda = $request->input('campo_legenda');
            $campoObrigatorio = $request->input('campo_obrigatorio');
            $campoOrdem = $request->input('campo_ordem');

            $insereCampos = array();
            if($campoMarcado != null){
                foreach($campoMarcado as $posicao => $campoId){
                    $dadosCampo['nome'] = $campoNome[$posicao];
                    $dadosCampo['legenda'] = $campoLegenda[$posicao];
                    $dadosCampo['obrigatorio'] = $campoObrigatorio[$posicao];
                    $dadosCampo['ordem'] = $campoOrdem[$posicao];
                    $insereCampos[$campoId] = $dadosCampo;
                }
            }
            $relatorio->campos()->attach($insereCampos);

            $campoObservado = $request->input('campo_observado');
            $camposSumarizados = $request->input('campos_sumarizados');
            $insereCamposSumarizados = array();
            $cont = 0;
            if($campoObservado != null){
                foreach($campoObservado as $posicao => $campoOb){
                    $insereCamposSumarizados[$cont]['campo'] = $campoOb;
                    $insereCamposSumarizados[$cont]['sumarizados'] = $camposSumarizados[$posicao];
                    $cont++;
                }
            }
            $relatorio->sumarizacao()->createMany($insereCamposSumarizados);
            DB::commit();
            $msg = 'alert-success|Relatório criado com sucesso!';
            return redirect()->route('relatorios.edit',[$relatorio->id])->with('alertMessage', $msg);
        } catch (Throwable $e) {
            DB::rollBack();
            $msg = 'alert-danger|Erro ao cadastrar relatório! Se persistir, comunique o administrador!';
            return redirect()->route('relatorios.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $relatorio = Relatorio::find($id);
        #dd($relatorio->sumarizacao);
        return view('relatorio.show',['relatorio' => $relatorio]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dados = Relatorio::find($id);
        $perfisMarcados = Permission::find($dados->permission_id)->roles()->pluck('id')->toArray();
        $camposId = $dados->campos->pluck('id')->toArray();
        $bancosDeDados = $this->bancosDeDados;
        $categorias = RelatorioCategoria::where('status','A')->orderBy('nome')->pluck('nome','id')->prepend('Selecione...','');
        $campos = RelatorioCampo::whereNotIn('id', $camposId)->where('status','A')->get();
        $perfis = Role::orderBy('name')->get();
        return view("relatorio.edit", [
                        'dados'=>$dados,
                        'perfisMarcados' => $perfisMarcados,
                        'categorias'=>$categorias,
                        'campos'=>$campos,
                        'bancosDeDados'=>$bancosDeDados, 
                        'perfis' => $perfis
                        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        try {
            DB::beginTransaction();
            $relatorio = Relatorio::find($id);
            $dadosPermissao['name'] = 'Relatório_Criado.'.$request->input('nome').' | '.$relatorio->categoria->nome;
            $relatorio->permissao()->update($dadosPermissao);
            $perfisMarcados = $request->input('perfis');
            DB::table('role_has_permissions')->where('permission_id', $relatorio->permission_id)->delete();
            if($perfisMarcados != null){
                foreach($perfisMarcados as $perfilId){
                    $perfil = Role::find($perfilId);
                    $perfil->givePermissionTo($relatorio->permission_id);
                }
            }

            $dados['nome'] = $request->input('nome');
            $dados['descricao'] = $request->input('descricao');
            $dados['query'] = $request->input('query');
            $dados['relatorio_categoria_id'] = $request->input('relatorio_categoria_id');
            $dados['banco_conexao'] = $request->input('banco_conexao');
            $dados['status'] = $request->input('status');

            $relatorio->update($dados);

            $campoMarcado = $request->input('campo');
            $campoNome = $request->input('campo_nome');
            $campoLegenda = $request->input('campo_legenda');
            $campoObrigatorio = $request->input('campo_obrigatorio');
            $campoOrdem = $request->input('campo_ordem');

            $insereCampos = array();
            if($campoMarcado != null){
                foreach($campoMarcado as $posicao => $campoId){
                    $dadosCampo['nome'] = $campoNome[$posicao];
                    $dadosCampo['legenda'] = $campoLegenda[$posicao];
                    $dadosCampo['obrigatorio'] = $campoObrigatorio[$posicao];
                    $dadosCampo['ordem'] = $campoOrdem[$posicao];
                    $insereCampos[$campoId] = $dadosCampo;
                }
            }
            $relatorio->campos()->sync($insereCampos);

            $campoObservado = $request->input('campo_observado');
            $camposSumarizados = $request->input('campos_sumarizados');
            $insereCamposSumarizados = array();
            $cont = 0;
            if($campoObservado != null){
                foreach($campoObservado as $posicao => $campoOb){
                    $insereCamposSumarizados[$cont]['campo'] = $campoOb;
                    $insereCamposSumarizados[$cont]['sumarizados'] = $camposSumarizados[$posicao];
                    $cont++;
                }
            }
            $relatorio->sumarizacao()->delete();
            $relatorio->sumarizacao()->createMany($insereCamposSumarizados);
            DB::commit();
            $msg = 'alert-success|Relatório alterado com sucesso!';
        } catch (Throwable $e) {
            DB::rollBack();
            $msg = 'alert-danger|Erro ao alterar relatório! Se persistir, comunique o administrador!';
        }
        return redirect()->route('relatorios.edit',[$relatorio->id])->with('alertMessage', $msg);
    }

    public function gerenciar(Request $request)
    {
        $buscar = $request->input('buscar');
        $relatorio = new Relatorio;
        if($buscar != null){
            $relatorio = $relatorio->where('nome','like',"%".$buscar."%");
        }
        return view('relatorio.gerenciar',['dados' => $relatorio->orderBy('nome')->get()]);
    }

    public function gerar(Request $request, $id)
    {
        $relatorio = Relatorio::find($id);

        $query = $this->montaQuery($relatorio->query, $request->except(['_token','campo','sumarizados']));
        if($request->input('debugar') != null){
            echo '<pre>';
            print_r($query);
            exit;
        }
        $rows = DB::connection($relatorio->banco_conexao)->select($query);
        $campos = (isset($rows[0]))? array_keys((array)$rows[0]): array();

        $dados = array();
        $posicoes = array();
        $camposSumarizar = array();
        if($request->input('campo') != null){
            foreach($request->input('campo') as $posicao => $campo){
                $camposSumarizar[$campo] = explode(',',$request->input('sumarizados')[$posicao]);
            }
        }
        
        $estiloCorCelula = array('FFFFFF00','B8860B','ADFF2F','F0E68C'); 
        $estiloConfig = $this->estiloConfig();
        $sharedStyle = new Style();
        $sharedStyle->applyFromArray($estiloConfig);

        $estiloControlaCor = 0;  
        $estiloLinha = array();  
        foreach($camposSumarizar as $chave => $campoSumarizar){ 
            $estiloLinha[$chave] = new Style();
            $estiloConfig['fill']['color']['argb'] = $estiloCorCelula[$estiloControlaCor];
            $estiloLinha[$chave]->applyFromArray($estiloConfig);
            $$chave = '';
            foreach($campoSumarizar as $campoSomar){
                $campoSumariza = $chave.'_'.$campoSomar;
                $$campoSumariza = 0;
            }
            $estiloControlaCor++;
        }
        
        $spreadsheet = new Spreadsheet();
        $contCampo = 1;

        foreach($campos as $campo){ 
            //Colore a fonte
            /*$spreadsheet->getActiveSheet()->getStyle('B2')
            ->getFont()->getColor()->setARGB(Color::COLOR_RED);*/      
            # Estiliza a linha em negrito
            $spreadsheet->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
            # Cria a coluna
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($contCampo, 1,  $campo);
            # Próxima coluna
            $contCampo++;
        }
        # Conteúdo a partir da segunda linha
        $linha = 2;
        if(count($rows) > 0){
            
            # Controla o campo da linha
            $coluna = 1;
            foreach($rows as $valor){ # Alimenta as colunas com o conteúdo
                $valor = (array) $valor;

                // Se linha for maior que 1, começa a verificação se existe agrupamento
                if($linha > 1){ 
                    // Se existe agrupamento e se o campo agrupamento for diferença de vazio 
                    if(isset($$agruparPorCampo) and $$agruparPorCampo != ''){
                        
                        foreach($camposSumarizar as $campoAgrupa => $camposSumariza){
                            if($$campoAgrupa != $valor[$campoAgrupa]){
                                $linha = $linha++;
                                $campoAgrupaPosicao = 1/*array_search($campoAgrupa, $campos) + 1*/;
                                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($campoAgrupaPosicao, $linha, $$campoAgrupa.' total:'); # Campo agrupamento
                                $vertical = $spreadsheet->getActiveSheet()->getHighestRow(); # Nº linha da célula
                                $horizontal = $spreadsheet->getActiveSheet()->getHighestColumn(); # Letra última célula
                                $spreadsheet->getActiveSheet()->duplicateStyle($estiloLinha[$campoAgrupa], 'A'.$vertical.':'.$horizontal.$vertical);
                                #$spreadsheet->getActiveSheet()->getStyle($linha)->getFont()->setBold(true); # Negrito
                                foreach($camposSumariza as $campoSomar){ // Pegas a colunas que foram somadas e coloca no excel
                                        $campoSumariza = $campoAgrupa.'_'.$campoSomar;
                                        $colunaSomar = array_search($campoSomar, $campos) + 1;
                                        #$spreadsheet->getActiveSheet()->getStyle($linha)->getFont()->setBold(true); # Negrito
                                        $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($colunaSomar, $linha, $$campoSumariza); # Conteúdo da célula
                                        $$campoSumariza = 0;
                                    
                                }
                                $linha++;
                            }
                        }
                    }
                    
                    foreach($camposSumarizar as $agruparPorCampo => $sumarizarCampos){
                        $$agruparPorCampo = $valor[$agruparPorCampo]; // Armazena a coluna agrupamento
                        foreach($sumarizarCampos as $campoSumarizar){
                            $campoSumariza = $agruparPorCampo.'_'.$campoSumarizar;
                            $$campoSumariza += round($valor[$campoSumarizar],2); // Sumariza as colunas definidas
                        
                        }
                    }
                    
                }
                
                foreach($campos as $campo){
                        # Exemplos: 10/06/2015 | 10/06/15 | 2015-06-10 | 15-06-10
                        if(preg_match('/^[0-9]{2,4}(-|\/)[0-9]{2}(-|\/)[0-9]{2,4}$/', trim($valor[$campo]))){ # Verifica se o conteúdo é uma data
                            # Adiciona o conteúdo - Data no formato Excel
                            # Se for data converte a string data para o formato data do Excel
                            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,  Date::PHPToExcel(trim($valor[$campo]))); #echo trim($valor[$campo]); echo '<br>'; echo $ExcelDateValue; exit();
                            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($coluna, $linha)->getNumberFormat()->setFormatCode('dd/mm/yyyy'); #PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH
                        }elseif(is_numeric(trim($valor[$campo])) and strlen(trim($valor[$campo])) >= 12){ # Se for um número muito grande converte pra string
                            $type = DataType::TYPE_STRING;
                            #$type = DataType::TYPE_NUMERIC;
                            $spreadsheet->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->setValueExplicit(trim($valor[$campo]), $type);
                        }else{ # Mantem o formato padrão
                            # Adiciona o conteúdo
                            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha, trim($valor[$campo]));
                        }

                    
                    # Segue pra próxima coluna
                    $coluna++;
                }
                # Retorno a primeira coluna    
                $coluna = 1;
                # Avança pra próxima linha
                $linha++; 
                
            } 
            if(count($camposSumarizar)>0){
            // Se existir sumarização. Sumariza no final da planilha os últimos registros
                foreach($camposSumarizar as $chave => $campoSumarizar){ 
                    $campoAgrupaPosicao = 1/*array_search($chave, $campos) + 1*/;
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($campoAgrupaPosicao, $linha, $chave.' total:'); # Campo agrupamento
                    foreach($campoSumarizar as $campoSomar){
                        $campoSumariza = $chave.'_'.$campoSomar;
                        $colunaSomar = array_search($campoSomar, $campos) + 1;
                        #$spreadsheet->getActiveSheet()->getStyle($linha)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($colunaSomar, $linha, $$campoSumariza);
                    }
                    $vertical = $spreadsheet->getActiveSheet()->getHighestRow();
                    $horizontal = $spreadsheet->getActiveSheet()->getHighestColumn();
                    $spreadsheet->getActiveSheet()->duplicateStyle($estiloLinha[$chave], 'A'.$vertical.':'.$horizontal.$vertical);
                    $linha++;
                }
            }
        }
        $this->forcarDownloadExcel($spreadsheet,$relatorio->nome);
    }

    public function montaQuery($query, $camposInputs)
    {
        foreach($camposInputs as $campo => $valor){ 
            # Data e Mês/Ano
            if(preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/', $valor) or preg_match('/^[0-9]{2}\/[0-9]{4}$/', $valor)){
                $valor = implode('-',array_reverse(explode('/',$valor)));
            }
            $query = str_ireplace($campo, $valor, $query);
        }
        return $query;
    }

    public function estiloConfig($estiloEscolhido = 0)
    {
        $estiloConfig[$estiloEscolhido] = [   
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFFFF00'],
            ],
            'borders' => [
                'top' => ['borderStyle' => Border::BORDER_THIN],
                'bottom' => ['borderStyle' => Border::BORDER_THIN],
                'right' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'font' => [
                'bold' => true,
            ],
        ]; 
        return $estiloConfig[$estiloEscolhido];
    }

    public function forcarDownloadExcel(Spreadsheet $spreadsheet, $nome_relatorio, $nomeExtra = '')
    {
        set_time_limit(0);
        $nomeComplemento = ($nomeExtra != '')? $nomeExtra: date('d_m_Y-H_i_s');
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$nome_relatorio.'_'.$nomeComplemento.'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $relatorio = Relatorio::find($id);
            $permissionId = $relatorio->permission_id;
            if($relatorio->delete()){
                Permission::find($permissionId)->delete();
                $msg = 'alert-success|Relatório apagado com sucesso!';
            }else{
                $msg = 'alert-danger|Erro ao apagar relatório! Se persistir, comunique o administrador!';
            }
        } catch (Throwable $e) {
            $msg = 'alert-danger|Erro ao apagar relatório! Se persistir, comunique o administrador!';
        }
        return redirect()->route('relatorio.gerenciar')->with('alertMessage', $msg);
    }
}
