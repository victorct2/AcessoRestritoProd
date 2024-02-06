<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

include APPPATH . 'third_party/google-api-php-client/vendor/autoload.php';

Class Analyticsapi {

    public $startDate = '';
    public $endDate = '';
    const VIEW_ID = "19283147";
    public $analytics = null;

    public function carregarAnalytics(){

        $client_credentials = APPPATH . 'third_party/client_secrets.json';
        $client = new Google_Client();
        $client->setAuthConfig($client_credentials);
        $client->setAccessType("offline");        // offline access
        $client->setIncludeGrantedScopes(true);   // incremental auth
        $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
            $this->analytics = new Google_Service_AnalyticsReporting($client);            
            return $this->analytics;
         } else {
             return false;
        }
    }

   public function oauth2callback(){
        $client_credentials = APPPATH . 'third_party/client_secrets.json';
        $client = new Google_Client();
        $client->setAuthConfigFile($client_credentials);
        $client->setRedirectUri(base_url() . 'RelatoriosControllerAnalytics/oauth2callback');
        $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
        return $client;       
    }

    function setStartDate($data){
        $this->startDate = $data;
    }

    function setEndDate($data){
        $this->endDate = $data;
    }

    /*
    ** Browsers Mais Utilizados
    */
    function getBrowserAnalytics($analyticsClass){
            
            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $browser = new Google_Service_AnalyticsReporting_Dimension();
            $browser->setName("ga:browser");

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($browser));
            $request->setMetrics(array($sessions));

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);            

           // return $reports;

            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }

    }

    /*
    ** Público Masculino e Feminino
    */
    function getInfoDemografAnalytics($analyticsClass){
            
            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $visitor = new Google_Service_AnalyticsReporting_Dimension();
            $visitor->setName("ga:userGender");

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($visitor));
            $request->setMetrics(array($sessions));

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);            

            //return $reports;

            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }

    /*
    ** Visão geral dos Dispositivos (Desktop,Mobile,Tablet)
    */
    function getMobileAnalytics($analyticsClass){
            
            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $mobile = new Google_Service_AnalyticsReporting_Dimension();
            $mobile->setName("ga:mobileDeviceInfo");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:sessions');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($mobile));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);            

            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }

    }

    /*
    ** Visão geral dos Dispositivos (Apple iPhone,Motorola MotoG3,Apple iPad)
    */
    function getDispositivosAnalytics($analyticsClass){
            
            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $mobile = new Google_Service_AnalyticsReporting_Dimension();
            $mobile->setName("ga:deviceCategory");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:sessions');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($mobile));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);            

            //return $reports;  
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }        

    }

    /*
    ** Redes Sociais (Facebook,Twitter,Youtube)
    */
    function getRedesSociaisAnalytics($analyticsClass){
            
            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $social = new Google_Service_AnalyticsReporting_Dimension();
            $social->setName("ga:socialNetwork");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:sessions');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($social));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);         

            //return $reports;   
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }         
    }

    /*
    ** Total de Sessões
    */
    function getTotalSessionsAnalytics($analyticsClass){
            
            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:uniqueDimensionCombinations");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:sessionDurationBucket");

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));

            /*echo 'teste: <pre>';
            print_r($analyticsClass->reports);
            echo '</pre>';
            //exit();*/

            if(count(@$analyticsClass->reports)>0){
                //echo 'Analytics ok';
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->totals[0]->values[0];  
            }else if(count(@$analyticsClass->reports)==0){
                //echo 'Analytics False';
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }

            
    }

    /*
    ** Total de Usuários
    */
    function getTotalUsersAnalytics($analyticsClass){
            
            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:users");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:userDefinedValue");

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->totals[0]->values[0];         
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->totals[0]->values[0];     
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }

    /*
    ** Total de Visualizações
    */
    function getTotalViewsAnalytics($analyticsClass){
            
            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:pageviews");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:hostname");

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->totals[0]->values[0];       
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->totals[0]->values[0];       
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }  
    }

    /*
    ** Total de Visualizações únicas
    */
    function getTotalUniqueViewsAnalytics($analyticsClass){
            
            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:uniquePageviews");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:hostname");

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->totals[0]->values[0];
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->totals[0]->values[0];
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
         
    }

    /*
    ** Sistemas Operacionais (Windows, Linux, Macintosh, or iOS)
    */
    function getOperationsSystemAnalytics($analyticsClass){
            
            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:operatingSystem");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:sessions');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
         
    }

    /*
    ** Idioma (pt-br, en, es)
    */
    function getIdiomaAnalytics($analyticsClass){
            
            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:language");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:sessions');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            $reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
         
    }

    /*
    ** Local (Brasil, Estados unidos, Espanha)
    */
    function getLocalAnalytics($analyticsClass){
            
            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:country");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:sessions');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
         
    }

   


    /*
    ** Visitantes novos e Recorrentes
    */
    function getNewAndReturnUsersAnalytics($analyticsClass){
            
            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:userType");       

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));            

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            $reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->totals[0]->values[0];
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
         
    }

    /*
    ** Usuários Ativos por 1,7,14,30
    */
    function getUserActiveByDay($analyticsClass,$days){

            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            if($days == 1){
                $sessions->setExpression("ga:1dayUsers");
            }else if($days == 7){
                $sessions->setExpression("ga:7dayUsers");
            }else if($days == 14){
                $sessions->setExpression("ga:14dayUsers");
            }else if($days == 30){
                $sessions->setExpression("ga:30dayUsers");
            }         
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:day");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:day');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return  $reports->reports[0]->data->rows[0]->metrics[0]->values[0];
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return  $reports->reports[0]->data->rows[0]->metrics[0]->values[0];
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }

    /*
    ** AQUISIÇÂO 
    ** Canais (Direct, Social, Organic)
    */
    function getCanaisAnalytics($analyticsClass){
            // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:channelGrouping");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:sessions');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }

    /*
    ** AQUISIÇÂO 
    ** Origem/Midia Todo Tráfego 
    */
    function getTodoTrafegoAnalytics($analyticsClass){
        // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:sourceMedium");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:sessions');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }


    /*
    ** AQUISIÇÂO 
    ** Tráfego de referência
    */
    function getTrafegoReferenciaAnalytics($analyticsClass){
        // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:source");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:sessions');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }

    
    /*
    ** AQUISIÇÂO 
    ** Referência redes Sociais
    */
    function getReferenciaRedesSociaisAnalytics($analyticsClass){
        // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
                       
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:socialNetwork");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:sessions');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }

    /*
    ** AQUISIÇÂO 
    ** Páginas de Destino
    */
    function getPaginasDestinoAnalytics($analyticsClass){
        // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
            $sessions1 = new Google_Service_AnalyticsReporting_Metric();
            $sessions1->setExpression("ga:pageviews");
            $sessions1->setAlias("sessions1");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:exitScreenName");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:sessions');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions,$sessions1));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }

    /*
    ** AQUISIÇÂO 
    ** Tráfego de pesquisa orgânica
    */
    function getPesquisaOrganicaAnalytics($analyticsClass){
        // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:keyword");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:sessions');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }


    /*
    ** Comportamento 
    ** Páginas de destino
    */
    function getPaginasDestinoCOAnalytics($analyticsClass){
        // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:landingPagePath");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:sessions');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }

     /*
    ** Comportamento 
    ** Páginas de Saída
    */
    function getPaginasSaidaAnalytics($analyticsClass){
        // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:sessions");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:exitPagePath");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:sessions');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }

    /*
    ** Comportamento 
    ** Detalhamento do conteúdo
    */
    function getDetalhamentoConteudoAnalytics($analyticsClass){
        // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:pageviews");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:pagePathLevel1");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:pageviews');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }

    /*
    ** Comportamento 
    ** Todas as Páginas
    */
    function getPaginasAnalytics($analyticsClass){
        // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:pageviews");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:pagePath");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:pageviews');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }

     /*
    ** Comportamento 
    ** Todas as Páginas
    */
    function getVelocidadePaginasSiteAnalytics($analyticsClass){
        // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:pageviews");
            $sessions->setAlias("sessions");
           
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:pagePath");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:pageviews');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }

    /*
    ** Comportamento 
    ** Eventos Principais
    */
    function getSambaTechAnalytics($analyticsClass){
        // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:totalEvents");
            $sessions->setAlias("sessions");
            $sessions2 = new Google_Service_AnalyticsReporting_Metric();
            $sessions2->setExpression("ga:uniqueEvents");
            $sessions2->setAlias("sessions2");

                       
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:eventAction");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:totalEvents');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions,$sessions2));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }


    /*
    ** Comportamento 
    ** Velocidade das páginas do site

    */
    function getTempoNaPaginaAnalytics($analyticsClass){
        // Create the DateRange object.
            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($this->startDate);
            $dateRange->setEndDate($this->endDate);

            // Create the Metrics object.
            $sessions = new Google_Service_AnalyticsReporting_Metric();
            $sessions->setExpression("ga:pageviews");
            $sessions->setAlias("sessions");
            $sessions2 = new Google_Service_AnalyticsReporting_Metric();
            $sessions2->setExpression("ga:avgPageLoadTime");
            $sessions2->setAlias("sessions2"); 
            $sessions3 = new Google_Service_AnalyticsReporting_Metric();
            $sessions3->setExpression("ga:exitRate");
            $sessions3->setAlias("sessions3"); 

                       
            //Create the Dimensions object.
            $session = new Google_Service_AnalyticsReporting_Dimension();
            $session->setName("ga:pagePath");

            $orderBy = new Google_Service_AnalyticsReporting_OrderBy();
            $orderBy->setFieldName('ga:pageviews');
            $orderBy->setOrderType('VALUE'); 
            $orderBy->setSortOrder('DESCENDING'); 

            // Create the ReportRequest object.
            $request = new Google_Service_AnalyticsReporting_ReportRequest();
            $request->setViewId(self::VIEW_ID);
            $request->setDateRanges($dateRange);
            $request->setDimensions(array($session));
            $request->setMetrics(array($sessions,$sessions2,$sessions3));
            $request->setOrderBys($orderBy);

            $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
            $body->setReportRequests(array($request));
            //$reports = @$analyticsClass->reports->batchGet($body);                    
            //return $reports->reports[0]->data->rows;
            if(count(@$analyticsClass->reports)>0){
                $reports = @$analyticsClass->reports->batchGet($body);                   
                return $reports->reports[0]->data->rows;
            }else if(count(@$analyticsClass->reports)==0){
                redirect(base_url().'RelatoriosControllerAnalytics/oauth2callback','refresh');
            }
    }


    

}
