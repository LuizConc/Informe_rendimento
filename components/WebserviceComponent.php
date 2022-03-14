<?php

namespace app\components;

use Exception;
use mongosoft\soapclient\Client;
use Yii;
use yii\base\Component;

class WebserviceComponent extends Component
{
    public $user;
    public $password;

    private $endPoint = [
        'reports' => 'https://web23.senior.com.br:40001/g5-senior-services/rubi_Synccom_senior_g5_rh_fp_relatorios?wsdl',
        'collaborator' => 'https://web23.senior.com.br:40001/g5-senior-services/rubi_Synccom_senior_g5_rh_fp_consultarColaboradorPorCPF?wsdl'
    ];

    public function getReports($type, $codUser, $date, $codType = 11)
    {
        try {
            $client = new Client([
                'url' => 'https://web23.senior.com.br:40001/g5-senior-services/rubi_Synccom_senior_g5_rh_fp_relatorios?wsdl',
            ]);

            $params = [
                'codUser' => $codUser,
                'date' => $date,
                'codType' => $codType
            ];

            $data = $this->getData($type, $params);

            $result = $client->Relatorios($this->user, $this->password, 0, $data);

            return $result;

        } catch (\Exception $e) {
            return 'OCORREU UM ERRO AO GERAR O RELATÓRIO, TENTE NOVAMENTE';
        }
    }

    public function getWebservice($endPoint, $parameters) {
        try {
            $client = new Client([
                'url' => $this->endPoint[$endPoint]
            ]);

            $data = $this->formatData($endPoint, $parameters);
            
            $result = $client->{$data['function']}($this->user, $this->password, 0, $data['parameters']);

            return $result;

        } catch (\Exception $e) {    
            return 'OCORREU UM ERRO AO GERAR O RELATÓRIO, TENTE NOVAMENTE';
        }
    }

    private function getData($type, $params) {
        switch ($type) {
            case 'informe-rendimento':
                $prEntradaArray = [
                    'eAnoBase' => $params['date'],
                    'eDatEnt' => '28/02/2022',
                    'eTipNot' => '000',
                    'eLisAut' => 1,
                    'eConIrf' => 'I',
                    'eConLim' => 'S',
                    'eRenAci' => 0,
                    'eCon13s' => 'N',
                    'eGraTab' => 'N',
                    'eNivOrd' => 0,
                    'eEndFon' => 0,
                    'eLisEve' => 'S',
                    'eSomTit' => 'N',
                    'e13sCpl' => 'A',
                    'eDesRee' => 'P',
                    'eAbrEmp' => 1,
                    'eAbrCad' => $params['codUser']
                ];
    
                $prEntrada = '';

                foreach ($prEntradaArray as $label => $value) {        
                    $prEntrada .= '<'.$label.'='.$value.'>';
                }

                $data = [
                    'prEntranceIsXML' => 'F',
                    'prExecFmt' => 'tefFile',
                    'prFileName' => 'InformeRendimento',
                    'prRelatorio' => 'FPIN001.ANU',
                    'prSaveFormat' => 'tsfPDF',
                    'prEntrada' => $prEntrada
                ];

                break;

            case 'holerite':
                
                $day = \DateTime::createFromFormat('m/Y', $params['date']);
                $lastDay = $day->format('t/m/Y');
                $firstDay = '01/'.$params['date']; #

                $prEntradaArray = [
                    'EIncOca' => 'N', 
                    'EMosBat' => 'A',
                    'EMarPon' => 'N',
                    'EIniPerCal' => $firstDay,
                    'EFimPerCal' => $lastDay,                    
                    'EAbrTipCal' => $params['codType'],
                    'EAbrEmp' => '1',
                    'EAbrTcl' => '1',                    
                    'EAbrCad' => $params['codUser']
                ];

                $prEntrada = '';    
                foreach ($prEntradaArray as $label => $value) { 
                    $prEntrada .= "<$label=$value>";  
                }

                $data = [
                    'prEntrada' => $prEntrada,
                    'prEntranceIsXML' => 'F',
                    'prExecFmt' => 'tefFile',
                    'prFileName' => 'Holerite',
                    'prRelatorio' => 'FPEN004.ENV',
                    'prSaveFormat' => 'tsfPDF'
                ];

                break;
        }

        return $data;
    }

    private function formatData($endPoint, $data) 
    {
        switch ($endPoint) {
            case 'collaborator':
                $result = $data;
                $function = 'ConsultarColaboradorPorCPF';
                break;
            default:
                $result = json_encode($data);
                break;
        }

        return ['parameters' => $result, 'function' => $function];
    }
}
