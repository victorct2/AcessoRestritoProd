<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



function initializeAnalytics(){
        $client_credentials = APPPATH . 'third_party/service-account-credentials.json';
        echo 'Json: '.$client_credentials;
		$client = new Google_Client();
        $client->setAuthConfig($client_credentials);
        $client->addScope(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new Google_Service_AnalyticsReporting($client);
        return $analytics;

}

function getReport($analytics) {

    // Replace with your view ID, for example XXXX.
    $VIEW_ID = "19283147";

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate("7daysAgo");
    $dateRange->setEndDate("today");

    // Create the Metrics object.
    $sessions = new Google_Service_AnalyticsReporting_Metric();
    $sessions->setExpression("ga:sessions");
    $sessions->setAlias("sessions");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setMetrics(array($sessions));

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests( array( $request) );
    return $analytics->reports->batchGet( $body );
}




?>