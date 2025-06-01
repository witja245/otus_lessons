<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Bizproc\Activity\BaseActivity;
use Bitrix\Bizproc\FieldType;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Localization\Loc;
use Bitrix\Bizproc\Activity\PropertiesDialog;
use Bitrix\Main\Diag\Debug;

class CBPSearchByInnActivity extends BaseActivity
{
    // protected static $requiredModules = ["crm"];

    /**
     * @param $name string Activity name
     * @see parent::_construct()
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->arProperties = [
            'Inn' => '',

            // return
            'Text' => null,
        ];

        $this->SetPropertiesTypes([
            'Text' => ['Type' => FieldType::STRING],
        ]);
    }

    /**
     * Return activity file path
     * @return string
     */
    protected static function getFileName(): string
    {
        return __FILE__;
    }

    /**
     * @return ErrorCollection
     */
    protected function internalExecute(): ErrorCollection
    {
        $errors = parent::internalExecute();

        $token = "0c825d0906122684951a7a3d60ee8848289d4344";
        $secret = "db2700343995d8f5e1992e0fcbd81ded70267e71";

        // token и secret лучше передавать в виде переменных БП в активити
        // $rootActivity->GetVariable("TOKEN"); 
        // $rootActivity->GetVariable("SECRET"); 

        $dadata = new \Dadata\DadataClient($token, $secret);

        $response = $dadata->suggest("party", $this->Inn, 1);

        $companyName = 'Компания не найдена!';
        if (!empty($response)) { // если копания найдена
            // по ИНН возвращается массив в котором может бытьнесколько элементов (компаний)
            $companyName = $response[0]['value']; // получаем имя компании из первого элемента
            try {
                $companyData = [
                    'TITLE' => $companyName,
                    "ASSIGNED_BY_ID" => 1,
                    'MODIFY_BY_ID' => 1
                ];


                $result = \Bitrix\Crm\CompanyTable::add($companyData);
                if ($result->isSuccess()) {
                    $companyId = $result->getId();
                    $rootActivity = $this->GetRootActivity(); // получаем объект активити
                    $documentType = $rootActivity->getDocumentType();
                    $documentId = $rootActivity->getDocumentId(); // получаем ID документа
                    $documentService = CBPRuntime::GetRuntime(true)->getDocumentService();
                    $documentFields = $documentService->GetDocumentFields($documentType);

                    foreach ($documentFields as $key => $value) {
                        if ($key == 'PROPERTY_ZAKAZCHIK') {
                            \CIBlockElement::SetPropertyValues(intval($documentId['2']), 21, 'CO_'.$companyId, 'ZAKAZCHIK');

                        }
                    }
                    $this->log('Компания успешно создана. ID: ' . $companyId);

                } else {
                    $this->log('Ошибка создания компании: ' . implode(', ', $result->getErrorMessages()));
                }
            } catch (Exception $e) {
                $this->log('Произошла ошибка: ' . $e->getMessage());
            }


        }

        return $errors;
    }

    /**
     * @param PropertiesDialog|null $dialog
     * @return array[]
     */
    public static function getPropertiesDialogMap(?PropertiesDialog $dialog = null): array
    {
        $map = [
            'Inn' => [
                'Name' => Loc::getMessage('SEARCHBYINN_ACTIVITY_FIELD_SUBJECT'),
                'FieldName' => 'inn',
                'Type' => FieldType::STRING,
                'Required' => true,
                'Options' => [],
            ],
        ];
        return $map;
    }


}