<?php

	// TERMINALFOUR
	// EVMS Private Site GLOBAL HEADER v2 - Phase 2
	// ===================================================================================
	session_start();  
	
	// GLOBAL Site Configuration
	// ---------------------------------------------------------------------------------
	$GLOBAL_config["loginpage"] = '/login/';					// T4 Tag Login page redirect original 211
	if(empty($GLOBAL_config["loginpage"])) { $GLOBAL_config["loginpage"] = "/login"; }
	// =================================================================================


	/* function: checkGroups
	 * Arguments: $groupindex (string/array),  $delimiter (string, defaults as ",")
	 * what: Takes in the supplied list of allowed groups and returns TRUE/FALSE based on if there is a match 	*/
	if (!function_exists('checkGroups')) {
		function checkGroups($groupindex="", $delimiter=","){
			if(!is_array($groupindex)){ $groupindex = explode($delimiter, $groupindex); }
			$groupindex = array_filter($groupindex, 'strlen');

			if(count($groupindex) <= 0) { return true; }		// IF no set groups, return true (display) or false (do not show)

			if(isset($_SESSION['userGroup_index'])){
				if(!is_array($_SESSION['userGroup_index'])){ $_SESSION['userGroup_index'] = explode($delimiter, $_SESSION['userGroup_index']); } 
				$matches = array_intersect($_SESSION['userGroup_index'], $groupindex);
				if(!empty($matches)){ return true; }
			} 
			return false;
		}
	}
	// =================================================================================
	
	
	// Check to see if user is requesting logout
	// ---------------------------------------------------------------------------------
	if(isset($_GET['logout'])){
		unset($_SESSION["userLogin"], $_SESSION["userGroup"], $_SESSION["userDisplayName"], $_SESSION["userGroup_index"]);
		session_destroy();
		
		// Remove the persistent cookie if set 
		if (isset($_COOKIE['userLogin'])) { setcookie ("userLogin", "", time() - 3600, '/'); }
		
		// HTTP 302 Redirect to Login page
		header('Location: '.$GLOBAL_config["loginpage"].'?loggedout');
		exit();	
	}
	// =================================================================================
	
	
	// Check to see if persistent cookie set
	// ---------------------------------------------------------------------------------
	if((isset($_COOKIE['userLogin'])) && (base64_decode($_COOKIE['userLogin'], true))) {
		
		// If session is not set, create it from cookie
		if(!isset($_SESSION["userLogin"])){
			$decodeCookie = base64_decode($_COOKIE['userLogin']);
			$sessionVars = explode("||", $cookieLogin);
			$_SESSION["userLogin"] = $sessionVars[0];
			$_SESSION["userGroup"] = $sessionVars[1];
			$_SESSION["userDisplayName"] = $sessionVars[2];
			$_SESSION['userGroup_index'] = $sessionVars[3];
		}	
	}
	// =================================================================================
	
	
	// Check to see if user is logged in
	// ---------------------------------------------------------------------------------
	if($_SERVER['SERVER_NAME'] !== "privatedev.evms.edu") {
		if(!isset($_SESSION["userLogin"])){
			// HTTP 302 Redirect to Login page
			if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) {
				header('Location: https://'.$_SERVER['HTTP_HOST'].$GLOBAL_config["loginpage"].'?redir='.$_SERVER["REQUEST_URI"]);
			} else {
				header('Location: '.$GLOBAL_config["loginpage"].'?redir='.$_SERVER["REQUEST_URI"]);
			}
		}
	} else if ($_SERVER['SERVER_NAME'] === "privatedev.evms.edu") {
                if(!isset($_SESSION["userLogin"])){
			// HTTP 302 Redirect to Login page
			header('Location: '.$GLOBAL_config["loginpage"].'?redir='.$_SERVER["REQUEST_URI"]);
		}
        }
	// =================================================================================
		
?><!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>COVID-19 Resources - myPortal</title>
  <meta name="description" content="">

  <meta name="author" content="">

  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- CSS concatenated and minified via ant build script-->
   <link rel="stylesheet" type="text/css" href="/media/evmspublic/evmsprivatedev/styleassets/css/responsivecss/media_7797_smxx.css" /> <!--responsiveprivatedev-style.css -->
  <link rel="stylesheet" type="text/css" href="/media/evmsprivatesite/styleassets/css/media_7912_smxx.css" /><!-- jquery-ui-1.8.18.custom.css -->
  <link rel="stylesheet" type="text/css" href="/media/evmspublic/evmsprivatedev/styleassets/css/responsivecss/MP-responsive.css" />
  <link rel="stylesheet" type="text/css" href="/media/evmsprivatesite/styleassets/css/checklist.css" /><!--accepted-portal.css-->
  <!-- end CSS-->
  <script src="/media/evmsprivatesite/styleassets/javascript/Media_7914_smxx.js"></script><!-- modernizr-2.0.6.min.js -->
  
	<!-- Internet Explorer HTML5 fix -->
	<!--[if lt IE 9]>
  		<link rel="stylesheet" type="text/css" href="/media/evmspublic/evmsprivatedev/styleassets/css/responsivecss/myPortal-ie8.css" />
		<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
<!--[if lt IE 9]>
<script>
document.createElement('header');
document.createElement('nav');
document.createElement('section');
document.createElement('article');
document.createElement('aside');
document.createElement('footer');
document.createElement('hgroup');
</script>
<![endif]-->
<!-- navigation object : Google Analytics --><!--t4 type="navigation" id="336"/-->
              <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-4920706-6', 'auto');
  ga('send', 'pageview');

</script>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-4920706-5"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-4920706-5');
</script>


<!-- Hotjar Tracking Code for https://www.evms.edu/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:2602492,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
        
    	  <?php include 'loopCode.php' ?>
<script src="https://kit.fontawesome.com/6089350608.js" crossorigin="anonymous"></script>
<script>
window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",

    {
      animationEnabled: true,
      animationDuration: 2000,
      interactivityEnabled: true,
      legend:{
        fontSize: 12,
      },
      zoomEnabled: true,
      panEnabled: true,
      axisY:{
        labelFontWeight: "light",
        labelFontSize: 15,
        maximum: 46,
        interval: 2,
      },
      axisX:{
        labelFontSize: 14,
        labelAngle: -75,
        title: "Week",
        titleFontSize: 16,
        interval: 1,
labelMaxWidth:100
      },
	data: [{
		color: "#041215",       
		name: "Tested",
		type: "line",
        showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	},
	{ color: "#14586b", 
        name: "Positive",
        type: "column",
        showInLegend: true,
        dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
      },
      { type: "column",
        name: "Positive Testing Offsite",
        showInLegend: true,
        color: " #1d7f9a ",
		dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>

      },
      { type: "column",
        name: "Hospitalized",
        color: "#249fc1",
        showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
        
      },
    {
      type: "column",
        name: "Hospitalized Tested Offsite",
        color: "#69c8e3",
        showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>

      }
      ]
});

    var chart1 = new CanvasJS.Chart("chartContainer1",

    {
      animationEnabled: true,
      animationDuration: 2000,
      interactivityEnabled: true,
      legend:{
        fontSize: 12,
      },
      zoomEnabled: true,
      panEnabled: true,
      axisY:{
        labelFontSize: 15,
        maximum: 8,
        interval: 1,
      },
      axisX:{
        labelFontSize: 12,
        labelAngle: 0,
        title: "Week",
        titleFontSize: 16,
        reversed:  true,
          interval: 1
      },
      data: [        
      { color: "#1d7f9a", 
        name: "Tested",
        type: "bar",
        showInLegend: true,
        dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>

      },
      {
      type: "bar",
        name: "Positive",
        color: "#69c8e3",
        showInLegend: true,
        dataPoints: <?php echo json_encode($dataPoints7, JSON_NUMERIC_CHECK); ?>
      }
      ]
    });
    chart.render();
    chart1.render();
  }
</script>
 <script type="text/javascript" src="https://myportal.evms.edu/downloads/graphs/canvasjs.min.js"></script>
<style>
.btn-dark-blue {
  border: #002539 3px solid;
  padding: 10px 10px;
  font-family: 'myriad-pro', sans-serif;
  width: 20%;
  text-align: center;
  border-radius: 10px;
  margin: 10px;
  min-width: 200px;
  display: flex;
  flex-direction: column;
}
.btn-dark-blue.resources {
  border: #002539 3px solid;
  padding: 10px 10px;
  font-family: 'myriad-pro', sans-serif;
  width: 30%;
  text-align: center;
  border-radius: 10px;
  margin: 10px;
  min-width: 200px;
  display: flex;
  flex-direction: column;
}

.resources .form {
  font-size: 2em;
  font-weight: 700;
  line-height: 1.25em;
}

.test-total {
  font-size: 3.5em;
  font-weight: 700;
  line-height: .7em;
  margin-top: 20px;
}

.totals {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
  width: 100%;
  color: #002539;
}
.form-links {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    width: 100%;
    color: #002539;
    }

.btn-dark-blue.resources p {
  font-family: "myriad-pro", 
  sans-serif;font-size: 1.15em;
  line-height: 1.5em;
  margin-bottom: 15px;
}

.schedule-section .two-column-page {
    background: none;
    display: flex;
    flex-direction: column;
    width: 100%;
    padding: 0;
    margin-top: 0;
}

.left { 
        float: left; 
        width: 100%; 
        margin: 0 0 0 0; 
    }
</style>
    </head>
<body class="cal_box">
<div class="content-shadow" id="wrappingDiv">
<div class="content-curve">
	<div class="container">
		<div class="inner-container">
			<header class="header">
          		<a href="#" class="mobileNav respondOnly">Expand Menu</a>
				<a href="#" class="searchBtn respondOnly">Search</a>
				<nav>
					<ul class="top-menu">
<li><a href="/network_center/training/webmail/" target="_blank">Email</a></li><li><a href="https://evms.blackboard.com/webapps/login/" target="_blank">Blackboard</a></li><li><a href="/departments/">Departments</a></li><li><a href="https://myportal.evms.edu/directory/?cacheupdate=true">Directory</a></li><li><a href="https://www.evms.edu/maps_directions_parking/" target="_blank">Campus Map</a></li><li><a href="/calendar-schedule-events/">Calendar</a></li><li><a href="/formssearch/">Forms</a></li><li><a href="/policies_and_procedures/">Policies</a></li><li><a href="/services_search/">Services</a></li><li><a href="/trainingsearch/">Training</a></li><li><a href="/departments/library/">Library</a></li><li><a href="/myevmsresources/">myEVMS Resources</a></li></ul> <!-- original value: 179 -->
				</nav>
		
				<a class="logo" href="/"><img src="/media/evmsprivatesite/styleassets/images/myPortal-2-159x40.png" alt="logo"></a>
				
				<ul class="user"><li><a href=""><?php if (!empty($_SESSION['userFirstName']) && !empty($_SESSION['userLastName'])) { echo "Welcome, ".$_SESSION['userFirstName']." ".$_SESSION['userLastName'].""; } else if (!empty($_SESSION['userDisplayName'])) { echo "Welcome, ".$_SESSION['userDisplayName'].""; } else { echo "Welcome"; } ?></a></li></ul>				
				
				<div class="dropDown">
					<div class="drop-down-top"></div>
					<div class="drop-down-content">
						<div class="drop-section2">
							<h5>My Favorites</h5>
							<ul class="headerBookmarks" >
								<li><strong><a href="{url}">{title}</a></strong></li>
							</ul>
							<a href="/myfavorites/">View all »</a>
						</div>
						<!-- navigation object : Private Dev: Header Dopdown --><div class="drop-section3">
    <ul>
        <li><a href="?logout">Logout</a></li>
        <li><a href="/usingtheintranet/">Using the Intranet</a></li>
	<li><a href="/help/">Help</a></li>
    </ul>
    <ul class="social">
        <li><a href="">Facebook</a></li>
	<li><a href="">Twitter</a></li>
        <li><a href="">YouTube</a></li>
	<li><a href="">RSS</a></li>
    </ul>
</div>
					</div>
					<div class="drop-down-bottom"></div>
				</div>

                                <form action="/search/" method="get">
<input type="hidden" placeholder="Search our website" id="evms-portal-collection" name="collection" value="evms-portal" />
<input type="text" placeholder="" id="evms-portal" name="query" />

<input class="search-btn" type="submit" name="btn_submit" value="Search" id="btn_submit" />

</form> <!-- original value: 181 -->
			</header>
					
			<div class="mega"></div>
				
			<div class="menu-container hasBreadCrumb">
			   	<nav class="main-nav-private">
                                  	<ul class="main-menu-private">
<li><a href="/administrative_services/">Administrative Services</a>
<ul class="multilevel-linkul-0">
<li><a href="/administrative_services/businessmanagement/">Business Management</a></li>
<li><a href="/research/safety/environmental_health_and_safety/">Environmental Health &amp; Safety</a></li>
<li><a href="/administrative_services/facilities/">Facilities</a></li>
<li><a href="/administrative_services/general_counsel/">General Counsel/Institutional Compliance</a></li>
<li><a href="/administrative_services/marketing/">Marketing &amp; Communications</a></li>
<li><a href="/administrative_services/materials_management/">Materials Management</a></li>
<li><a href="/administrative_services/occupationalhealth/">Occupational Health</a></li>
<li><a href="/administrative_services/police/">Police &amp; Public Safety</a></li>
<li><a href="/administrative_services/risk_management/">Risk Management</a></li>
<li><a href="/administrative_services/specialevents/">Special Events</a></li>

</ul>

</li><li><a href="/humanresources/">Human Resources</a>
<ul class="multilevel-linkul-0">
<li><a href="/humanresources/dolvastatelaborlawposters/">DOL &amp; VA State Labor Law Posters</a></li>
<li><a href="/humanresources/employeeholidays/">Employee Holidays</a></li>
<li><a href="/formssearch/index.php?action=searchform&search-value=All&q=&filter-department=Human+Resources&filter-category=&filter-type=">Forms</a></li>
<li><a href="/humanresources/insurancebenefits/">Insurance &amp; Benefits</a></li>
<li><a href="/humanresources/jobs/">Jobs</a></li>
<li><a href="/humanresources/leaveofabsenceandaccommodationrequests/">Leave of Absence and Accommodation Requests </a></li>
<li><a href="/humanresources/managerandsupervisorytrainingandresources/">Manager and Supervisory Training and Resources</a></li>
<li><a href="/humanresources/new_employee_information/">New Hire Faculty &amp; Staff Onboarding Information</a></li>
<li><a href="/humanresources/payroll/">Payroll</a></li>
<li><a href="/humanresources/percipioe-learningportal/">Percipio E-Learning Portal</a></li>
<li><a href="/humanresources/performancemanagement/">Performance Management</a></li>
<li><a href="/policies_and_procedures/index.php?action=searchform&search-value=All&q=&filter-department=Human+Resources&filter-category=&filter-type=">Policies</a></li>
<li><a href="/humanresources/equalemploymentopportunityandaffirmativeactionprogram/">Equal Employment Opportunity and Affirmative Action Program </a></li>
<li><a href="/education/student_affairs/safezone/">Safe Zone</a></li>
<li><a href="/humanresources/staff/">Staff</a></li>
<li><a href="/humanresources/wellnessworks/">Wellness Works</a></li>
<li><a href="/humanresources/contactus/">Contact Us</a></li>

</ul>

</li><li><a href="/informationtechnology/">Information Technology</a>
<ul class="multilevel-linkul-0">
<li><a href="/ais/">Academic Information System Project</a></li>
<li><a href="https://myportal.evms.edu/staff/policies_and_procedures/?action=searchform&search-value=All&filter-type=&filter-department=Information+Technology&q=">Policies &amp; Procedures</a></li>
<li><a href="/informationtechnology/businessservicecenterbsc/">Business Service Center (BSC)</a></li>
<li><a href="/informationtechnology/databasecenterdbc/">Database Center (DBC)</a></li>
<li><a href="/informationtechnology/mediaaudiovisualtechnicalservicesmavts/">Media &amp; Audio Visual Technical Services (MAVTS)</a></li>
<li><a href="/informationtechnology/networkinformationcenternic/">Network Information Center (NIC)</a></li>
<li><a href="/informationtechnology/telecommunications/">Telecommunications</a></li>
<li><a href="/informationtechnology/networkinformationcenternic/duotwo-factorauthentication/">Duo two-factor authentication</a></li>
<li><a href="https://myportal.evms.edu/staff/formssearch/?action=searchform&search-value=All&filter-type=&filter-department=Information+Technology&use+existing=">Forms</a></li>
<li><a href="/informationtechnology/staff/">Staff</a></li>
<li><a href="/informationtechnology/contactus/">Contact Us</a></li>
<li><a href="/informationtechnology/softwaredownload/">Software Download</a></li>
<li><a href="/informationtechnology/enterprisevault/">Enterprise Vault</a></li>
<li><a href="https://myportal.evms.edu/media/evmsprivatesite/information_technology_remote_services.pdf">Remote Services and Applications Guide</a></li>

</ul>

</li><li><a href="/financialservices/">Financial Services</a>
<ul class="multilevel-linkul-0">
<li><a href="/financialservices/accounts_receivable_and_student_billing/">Accounts Receivable and Student Billing</a></li>
<li><a href="/financialservices/budgetoffice/">Budget Office</a></li>
<li><a href="/financialservices/payroll/">Payroll</a></li>
<li><a href="/financialservices/contactus/">Contact Us</a></li>
<li><a href="/financialservices/student_loan_office/">Student Loan Office</a></li>
<li><a href="/financialservices/staff/">Staff</a></li>
<li><a href="/financialservices/generalaccounting/">General Accounting</a></li>
<li><a href="/financialservices/financialsystems/">Financial Systems</a></li>
<li><a href="/financialservices/procurementcard/">Procurement Card</a></li>
<li><a href="/financialservices/accountspayable/">Accounts Payable</a></li>
<li><a href="/education/financial_aid/">Student Financial Aid</a></li>

</ul>

</li><li><a href="/education/">Education</a>
<ul class="multilevel-linkul-0">
<li><a href="/education/campushousing/">Campus Housing</a></li>
<li><a href="/departments/clinicaleducationrecruitmentandsupport/">Clinical Education Recruitment and Support</a></li>
<li><a href="/education/community-engagedlearning/">Community-Engaged Learning</a></li>
<li><a href="/education/faculty_affairs/">Faculty Affairs</a></li>
<li><a href="/education/facultysenate/">Faculty Senate</a></li>
<li><a href="/education/financial_aid/">Financial Aid</a></li>
<li><a href="/education/graduatemedicaleducation/">Graduate Medical Education</a></li>
<li><a href="/education/mdprogramcurriculummap/">MD Program Curriculum Map</a></li>
<li><a href="/informationtechnology/mediaaudiovisualtechnicalservicesmavts/">Media Services</a></li>
<li><a href="/education/medicaleducationcommittee/">Medical Education Committee</a></li>
<li><a href="/administrative_services/occupationalhealth/">Occupational Health</a></li>
<li><a href="/education/programs/">Programs</a></li>
<li><a href="/education/scsil/">Sentara Center for Simulation and Immersive Learning</a></li>
<li><a href="/education/student_affairs/">Student Affairs</a></li>
<li><a href="https://mysis.evms.edu/" target="_blank">Student Information System</a></li>
<li><a href="https://evms.formstack.com/forms/school_of_medicine_student_recognition_form" target="_blank">Student Recognition Form</a></li>

</ul>

</li><li><a href="/research/">Research</a>
<ul class="multilevel-linkul-0">
<li><a href="/research/administration/">Administration</a></li>
<li><a href="/research/research_compliance/">Research Compliance</a></li>
<li><a href="/research/training_programs_and_events/">Training Programs &amp; Events</a></li>
<li><a href="/research/safety/">Safety</a></li>
<li><a href="https://researchers.evms.edu/" target="_blank">Researchers@EVMS</a></li>
<li><a href="/research/animal_research/">Animal Research</a></li>
<li><a href="/formssearch/?action=searchform&search-value=All&filter-department=Research&filter-type=&q=">Forms</a></li>
<li><a href="/research/funding/">Funding </a></li>
<li><a href="/research/researchdevelopment/">Research Development</a></li>
<li><a href="/research/institutionalreviewboard/">Institutional Review Board</a></li>
<li><a href="/research/equipment/">Equipment</a></li>

</ul>

</li></ul><!-- Original value: 184 ; new 331-->
		     		</nav>	
			</div>
                                                <div class="content">			
				<div class="breadcrumbs">
					<div class="pagePath">
                                          	
					</div>
					<!-- navigation object : Private Dev: AddThis and fontResizer --><div class="pageLinks">
    <ul class="actions">                  
	<!--<li class="share">--><!-- AddThis Button BEGIN -->
<!--
            <a href="https://www.addthis.com/bookmark.php?v=250&amp;pubid=ra-4ffaf90f0d804be8" class="addthis_button"><img width="16" height="16" style="border:0" alt="Bookmark and Share" src="/media/evmspublic/content/styleassets/images/Media_8357_smxx.jpg"></a>
            <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
	    <script src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4ffaf90f0d804be8" type="text/javascript"></script><div style="visibility: hidden; height: 1px; width: 1px; position: absolute; z-index: 100000;" id="_atssh"><iframe id="_atssh162" title="AddThis utility frame" style="height: 1px; width: 1px; position: absolute; z-index: 100000; border: 0pt none; left: 0pt; top: 0pt;" src="//ct5.addthis.com/static/r07/sh101.html#"></iframe></div><script type="text/javascript" src="https://ct5.addthis.com/static/r07/core041.js"></script>
	    --><!-- AddThis Button END -->
        <!--</li>-->
	<li class="email"><a href="https://evms.supportsystem.com/" target="_blank"><span>Email</span></a></li>                
	<li class="print"><a href=""><span>Print</span></a></li>
        <li class="Bookmark"><a href="javascript:;" onClick="addBookmark()"><span>Bookmark</span></a></li>
    </ul>
    <ul id="fontResizer" class="fontResizer">
        <li class="textLarge"><a href="#" title="Large Text Size">A</a></li>
	<li class="textMedium"><a class="selected" href="#" title="medium Text Size">A</a></li>
	<li class="textNormal"><a href="#" title="normal Text Size" class="active">A</a></li>
    </ul>
</div>		
				</div>
                                <h1>COVID-19 Resources</h1>
				<article class="left">
                  <div class="leftInner">
                                <!--  Added for Quick Links Navigation-->
                                <!--  <div class="quick-links">-->
					<!--<h2>Quick Links</h2>-->
					<!--<ul><li><a href="/covid-19resources/covid-19surveys/">COVID-19 Surveys</a></li><li><a href="/covid-19resources/covid-19sponsoredprogramsguidance/">COVID-19: Sponsored Programs Guidance</a></li><li><a href="https://www.evms.edu/covid-19/" target="_blank">COVID-19 Advisories</a></li><li><a href="/covid-19resources/covid-19forms/">COVID-19 Forms</a></li><li><a href="/covid-19resources/vaccination/">Vaccination</a></li></ul> Quick links -->
                                    
				<!--</div>-->
                                  <!--End of Quick Links-->
					
                                  <div class="schedule-section">
                                    <div class="two-column-page">
<div class="form-links">
     <div class="btn-dark-blue resources"><p>Vaccination Reporting</p>
          <a href="https://live.origamirisk.com/Origami/IncidentEntry/Direct?token=0qWqvfkh0fZMB46dXqp0d7zoP86txDUauMLfe8L5lF%2B%2FtTNk8bgz9om67MjrM20yvj7xvXTrk55rlKF2ZJYdm3bw8mlyQwoIaSyEl1AzJNMxTH%2Bajw1hvHKbMu5qqpLr&CollectionLinkItemID=6" class="form">EVMS VAX Portal</a>
<a href="https://myportal.evms.edu/covid-19resources/vaccination/">Vaccination Requirement information</a>
     </div>
     <div class="btn-dark-blue resources"><p>Exposure/Illness Reporting</p>
          <a href="https://nala.evms.edu/redcap/surveys/?s=9EDYXK74RA" target="_blank" class="form">REDCap Exposure Survey</a>
<a href="https://www.evms.edu/covid-19/what_should_i_do/employees/" target="_blank">Exposure/Illness information</a>
     </div>
</div><h2 style="margin-top: 30px;">EVMS Covid-19 Drive Through Testing: Employees and Students Data</h2>

<div class="totals">
     <div class="btn-dark-blue">Total Employees/Students Tested
          <div class="test-total"> 1133 </div>
     </div>
      <div class="btn-dark-blue">Total Positive Drive Through
           <div class="test-total">89</div>
       </div>
        <div class="btn-dark-blue">Total Positive Offsite
              <div class="test-total">102</div>
         </div>
         <div class="btn-dark-blue">Cumulative Positivity Rate
                 <div class="test-total">16.86%</div>
          </div>
</div>
<div id="chartContainer" style="height:800px; width: 100%;"></div>
<table style="position: relative; width:100%; margin:30px auto;" summary="COVID-19 data tested, positive hospitalized, drive through and offsite - Students and Employees">
<tbody><tr>
     <th scope="col" style="width:5%; padding: 5px;"> Week </th>
     <th scope="col" style="width: 10%; padding: 5px; text-align:left;"> Date Range </th>
     <th scope="col" style="width:10%; padding: 5px;"> Appointments </th>
     <th scope="col" style="width:10%; padding: 5px;"> Tested Drive Through </th>
     <th scope="col" style="width:10%; padding: 5px;"> Positive Drive Through </th>
     <th scope="col" style="width:10%; padding: 5px;"> Positive Tested Offsite</th>
     <th scope="col" style="width:10%; padding: 5px;"> Cumulative Positive Rate </th>
     <th scope="col" style="width:10%; padding: 5px;"> Hospitalized Drive Through </th>
     <th scope="col" style="width:10%; padding: 5px;"> Hospitalized Tested Offsite</th>
</tr>	

<?php 
    $weekCount = 1;
    $appsTotal = 0;
    $testedTotal = 0;
    $empPosTotal = 0;
    $positiveOffTotal = 0;
    $hospitializedTotal = 0;
    $hospitializedOffTotal = 0;
	for ($x=$NaN; $x < count($dates); $x++){
		
		$weeksBot = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['Week'];
		$weekValueBot = substr($weeksBot, 3);
		//appointments
        $appointments = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID__of_Drive_Through_Appointments'];
        $appsTotal = $appsTotal + $appointments;
		//number of tested
        $tested = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID__Employees_Students_Tested'];
        $testedTotal = $testedTotal + $tested;
        
		// numbers positive[2]['@attributes']
        $empPos = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID__Employees_Positive'];
        $empPosTotal = $empPosTotal + $empPos;

		// positive testing offsite
        $positiveOff = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID_positive_reported__testing_done_elsewhere_3'];
        $positiveOffTotal = $positiveOffTotal + $positiveOff;
		// Cumumative Posiive rate
		$posRate = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['Textbox18'];
		$posRatePer = number_format($posRate,4)*100;
		// hospitialized
        $hospitialized = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID__Employees_Positive_Hospitalized'];
        $hospitializedTotal = $hospitializedTotal + $hospitialized;
		// hospitialized offsite 
        $hospitializedOff = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID_positive_reported__testing_done_elsewhere__Hospitalized'];
        $hospitializedOffTotal = $hospitializedOffTotal + $hospitializedOff;
		//cumuliative positive rate
		$rate = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['Textbox35'];

		
			echo '<tr><th scope="col" style="width:5%; padding: 5px;">' . $weekCount . '</th> <th scope="col" style="width: 15%; padding: 5px; text-align:left;">' . $weekValueBot . '</th><th scope="col" style="width:10%; padding: 5px;">' . $appointments . '</th><th scope="col" style="width:10%; padding: 5px;">' . $tested . '</th><th scope="col" style="width:10%; padding: 5px;">'  . $empPos .
        '</th> <th scope="col" style="width: 10%; padding: 5px; text-align:left;">' . $positiveOff . '</th> <th scope="col" style="width: 10%; padding: 5px; text-align:left;">' . $posRatePer . '%</th> <th scope="col" style="width: 10%; padding: 5px; text-align:left;">' . $hospitialized . '</th> <th scope="col" style="width: 10%; padding: 5px; text-align:left;">' . $hospitializedOff . '</th>';
        
       
        $weekCount++;
        
    }

  

 echo '<tr><th scope="row" style="font-weight: 700;"> Totals</th><td> &nbsp; </td><td style="width:10%; padding: 5px; font-weight:700">'. $appsTotal .' </td><td style="width:10%; padding: 5px; font-weight:700">' . $testedTotal . '</td> <td style="width:10%; padding: 5px; font-weight:700">'. $empPosTotal .' </td><td style="width:10%; padding: 5px; font-weight:700">'. $positiveOffTotal .'</td><td style="text-align:center; "> &nbsp; </td><td style="width:10%; padding: 5px; font-weight:700">' . $hospitializedTotal . '</td><td style="width:10%; padding: 5px; font-weight:700">' . $hospitializedOffTotal . '</td></tr>';
?>
		</tbody>
	</table><h2 style="margin-top:30px;">EVMS Covid-19 Patient Testing Data</h2>
<div class="totals">
     <div class="btn-dark-blue">Total Patients Tested
          <div class="test-total"> 89 </div>
     </div>
     <div class="btn-dark-blue">Total Patients Positive
          <div class="test-total"> 21 </div>
     </div>
         <div class="btn-dark-blue">Cumulative Patient Positivity Rate
                 <div class="test-total">23.6%</div>
          </div>
</div>
<div id="chartContainer1" style="height: 800px; width: 1200px"></div>

  <table style="margin-top:30px;" summary="COVID-19 Patients tested and positive">  
    <tbody>
  <tr>
    <th scope="col" style="padding: 5px;"> Week </th>
    <th scope="col" style="padding: 5px; text-align:left;"> Date Range </th>
    <th scope="col" style="padding: 5px;"> Patients Tested </th>
    <th scope="col" style="padding: 5px;"> Patients Positive </th>
    <th scope="col" style="padding: 5px;"> Cumulative Positive Rate </th>
  </tr>
  <tr>

<?php 
        $weekCount=1;
        $patsTestedTotal = 0;
        $patsPosTotal = 0;
	    for ($x=$NaN; $x < count($dates); $x++){
		
		$weeksBot = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['Week'];
		$weekValueBot = substr($weeksBot, 3);
		//appointments
        $patsTested = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID__Patients_Tested'];
        $patsTestedTotal = $patsTestedTotal + $patsTested;
		//number of tested
        $patsPos = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID__Patients_Positive'];
        $patsPosTotal = $patsPosTotal + $patsPos;
	
		// Cumumative Posiive rate
		$posRate = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['Textbox35'];
		$posRatePer = number_format($posRate,4)*100;
		

		
		echo '<tr><th scope="col" style="width:5%; padding: 5px;">' . $weekCount . '</th> <th scope="col" style="width: 10%; padding: 5px; text-align:left;">' . $weekValueBot . '</th><th scope="col" style="width:10%; padding: 5px;">' . $patsTested . '</th><th scope="col" style="width:10%; padding: 5px;">' . $patsPos . 
		'</th><th scope="col" style="width: 10%; padding: 5px; text-align:left;">' . $posRatePer . '%</th></tr>' ;
		$weekCount++;
    }
    

echo '<th scope="row" style="font-weight: 700;"> Totals</th><td> &nbsp; </td><td style="width:10%; padding: 5px; font-weight:700">' . $patsTestedTotal .  ' </td><td style="width:10%; padding: 5px; font-weight:700">' .$patsPosTotal . '</td><td style="text-align:center;"> &nbsp; </td></tr></tbody></table>'
?>




</tr>

</tbody>
  </table>
</div><?php if(checkGroups('0')) { ?>
<a id="d.en.139804"></a>
<div class="three-col-section">



<!-- T4 select output. link box
-->


<h2>EVMS Patient Care&nbsp;</h2>
<ul>
<li><a href="/media/evmsprivatemediarestricted/allportal/Billing Instructions for COVID-19 Testing.pdf" target="_blank">Billing Instructions for COVID-19 Testing</a> (Last Updated 04/13/2020)</li>
<li><a href="/media/evmsprivatemediarestricted/allportal/ROUTINE CLEANING OF PATIENT CARE AREAS.pdf" target="_blank">Cleaning of Patient Care Areas</a></li>
<li><a href="/media/evmsprivatemediarestricted/allportal/EVMS HOUSEKEEPING PROTOCOL_CLINICAL_COVID19_20200504docx.pdf" target="_blank">Clinical Houskeeping Protocol</a></li>
<li><a href="/media/evmsprivatemediarestricted/allportal/EVMS-COVID19-3-15-20-Clinical-Evaluation-Guide.pdf" target="_blank">COVID-19 Clinical Evaluation Guide 3-15-20</a></li>
<li><a href="/media/evmsprivatemediarestricted/allportal/EVMS-COVID-19-Protocol-3-12-20.pdf" target="_blank">COVID-19 Protocol 3-12-20</a></li>
<li><a href="/media/evmsprivatesite/contentassets/documents/COVID Quick Referrence  treatment guidelines 03.25.2020.pdf" target="_blank">COVID Quick Reference Treatment Guidelines</a> (Last Updated 3-25-2020)</li>
<li><a href="/media/evmsprivatesite/EVMS COVID-19 Testing Appropriateness Criteria.pdf" target="_blank">COVID-19 Testing Appropriateness Criteria</a> (Last Updated 6-09-2020)</li>
<li><a href="/media/evmsprivatemediarestricted/allportal/EVMS Drive Through Progress Note.pdf" target="_blank">Drive-Through Progress Note 3-18-20</a></li>
<li><a href="https://covid19healthliteracyproject.com/" target="_blank">Fact Sheets for Non-English-Speaking Patients</a>&nbsp;Updated regularly by Harvard Medical School</li>
<li><a href="/media/evmsprivatemediarestricted/allportal/2019-ncov ambulatory care algorithm_rev03042020.pdf" target="_blank">Guidance for Ambulatory Care Setting</a></li>
<li><a href="/media/evmsprivatemediarestricted/allportal/Pregnant HCP EVMS-March23.pdf" target="_blank">Guidance for Pregnant or Lactating Health Care Personnel</a></li>
<li><a href="/media/evmsprivatesite/Outpatient Assessment and Management for Pregnant Women With Suspected or Confirmed COVID-19.pdf" target="_blank">Outpatient Assessment Management for Pregnant Women Suspected or Confirmed COVID</a> (Last Updated 03-23-2020)</li>
<li><a href="/media/evmsprivatemediarestricted/allportal/PatientAppointsDuringCOVID19.pdf" target="_blank">Patient Appointments during COVID-19</a></li>
<li><a href="/media/evmsprivatesite/contentassets/documents/EVMS PPE Recommendations for Providing Clinical Care.pdf" target="_blank">PPE Recommendations for Providing Clinical Care</a>&nbsp; (Last Updated 06-30-2020)</li>
<li><a href="/media/evmsprivatemediarestricted/allportal/EVMS_MG_post_exposure_protocol_summary_for_HCP.pdf" target="_blank">EVMS Medical Group Post-Exposure Protocol for Healthcare Personnel</a> (Last Updated 01-04-2022)</li>
<li><a href="/media/evmsprivatesite/contentassets/documents/COVID-19 EVMS Medical Group Quality Office Hotline 03-26-2020.pdf" target="_blank">Quality Office Hotline</a> (Last Updated 03-26-2020)</li>
<li><a href="/media/evmsprivatemediarestricted/allportal/SARS CoV 2 Rapid Ag and PCR testing algorithm 12 24 2020 (1).pdf" target="_blank">SARS CoV 2 Rapid Ag and PCR testing algorithm</a> (Last Updated 1-26-2021)</li>
<li><a href="/media/evmsprivatemediarestricted/allportal/Sentara EVMS Treatment Guidelines for SARS-CoV-2 infection 3.24.2020.pdf" target="_blank">Sentara-EVMS Treatment Guidelines for SARS-CoV-2 infection -- 3.24.2020</a></li>
<li><a href="/media/evmsprivatemediarestricted/allportal/SQCN-Clinical-Pearls-ID-COVID-19-Dr.-Oldfiled.pdf" target="_blank">SQCN Clinical Pearls ID COVID-19, Dr. Oldfield</a></li>
<li><a href="/media/evmsprivatesite/contentassets/documents/Procedure_PPEMaskingHandHygeineGuidelines.pdf" target="_blank">Universal masking, hand hygiene and PPE recommendations</a> (Last Updated 05-11-2020)</li>
</ul>
<p>&nbsp;</p>
<h2>Self-Monitoring Sheets</h2>
<ul>
<li><a href="https://www.evms.edu/media/evms_public/departments/covid-19/asymptomatic-exposed-employee-self-monitoring.pdf" target="_blank">Asymptomatic Exposed Employee Self-Monitoring</a></li>
<li><a href="https://www.evms.edu/media/evms_public/departments/covid-19/symptomatic-employee-self-monitoring.pdf" target="_blank">Symptomatic Employee Self Monitoring</a></li>
</ul>
<p>&nbsp;</p>
<h2>Telehealth</h2>
<ul>
<li><a href="/media/evmsprivatesite/contentassets/documents/EVMS Medical Group Telehealth & Non-Face-to-Face Services Guide.pdf" target="_blank">Telehealth  Non-Face-to-Face Services Guide</a> (Last Updated 06-25-2020)</li>
<li><a href="/media/evmsprivatesite/contentassets/documents/Talking Points for FollowMyHealth.pdf" target="_blank">Talking Points for FollowMyHealth</a> (Last Updated 03-30-2020)</li>
<li><a href="/media/evmsprivatesite/contentassets/documents/Tips on assisting with Telehealth Visits.pdf" target="_blank">Tips on assisting with Telehealth Visits</a> (Last Updated 04-03-2020)</li>
</ul>
<p>&nbsp;</p>
<h2>EVMS Research</h2>
<ul>
<li><a href="/media/evmsprivatemediarestricted/allportal/Sponsored Project_COVID-19 Information for the EVMS Research Community updated 03182020_V2.docx.pdf" target="_blank">COVID-19 Information for the EVMS Research Community</a></li>
<li><a href="/media/evmsprivatesite/contentassets/documents/CompMed and IACUC Considerations 03-24-2020.pdf" target="_blank">CompMed and IACUC Considerations 03-24-2020</a></li>
<li><a href="/media/evmsprivatemediarestricted/allportal/Disinfection Request Form.pdf" target="_blank">Disinfection Request Form</a></li>
<li><a href="/media/evmsprivatemediarestricted/allportal/IRB-COVID FAQ PAGE-3-17-2020-NCedits.pdf" target="_blank">FAQs on Clinical Trials/Research Studies at EVMS</a></li>
<li><a href="/media/evmsprivatemediarestricted/allportal/Lab Emergency Checklist.pdf" target="_blank">Lab Emergency Checklist</a></li>
<li><a href="/media/evmsprivatemediarestricted/allportal/LabCorp-Specimen-Collection-and-Shipping-Instructions.pdf" target="_blank">LabCorp Specimen Collection and Shipping Instructions</a></li>
<li><a href="/media/evmsprivatemediarestricted/allportal/LabCorp-Specimen-Collection-Guide.pdf" target="_blank">LabCorp Specimen Collection Guide</a></li>
<li><a href="/media/evmsprivatesite/contentassets/documents/SBARUpdated_LabCorpTesting_03172020.pdf" target="_blank">SBAR Updated LabCorp Testing 03172020</a></li>
<li><a href="/covid-19resources/covid-19sponsoredprogramsguidance/">Sponsored Programs Guidance</a></li>
</ul>
<p>&nbsp;</p>
<h2>CDC Resources</h2>
<ul>
<li><a href="/media/evmsprivatemediarestricted/allportal/caring-for-patients-COVID19.pdf" target="_blank">COVID-19 - Caring for Patients</a></li>
<li><a href="/media/evmsprivatemediarestricted/allportal/PPE-Sequence.pdf" target="_blank">Sequence for personal protective equipment (PPE)</a></li>
</ul>
</div>
<?php } ?>
<!--
/covid-19resources/graph-zoom-pan.mp4
--><!--
/covid-19resources/loopCode.php
--><!--
/covid-19resources/covid-testing.xml
-->                                            </div>
                                            </div>


						<a href="" class="backTo">Back to Top</a>
					</div>
				</article>
				<aside class="right">
                                  <!-- navigation object : Calendar Box Output --> 
                                  
				 <ul class="drop-list">
                                   <li> <a href="">More Information</a>
                                   <!-- navigation object : Additional Navigation --><ul><li><a href="/covid-19resources/covid-19surveys/">COVID-19 Surveys</a></li><li><a href="/covid-19resources/covid-19sponsoredprogramsguidance/">COVID-19: Sponsored Programs Guidance</a></li><li><a href="https://www.evms.edu/covid-19/" target="_blank">COVID-19 Advisories</a></li><li><a href="/covid-19resources/covid-19forms/">COVID-19 Forms</a></li><li><a href="/covid-19resources/vaccination/">Vaccination</a></li></ul>
                                  
                                   </li>
                                   </ul>
                                  
                                  
                                  
                                 
				</aside>
			</div>
		    </div>
		</div>
	</div>
</div>
</div><!--! end of #container -->

<footer class="footer">
	<div class="footer-content">
		<nav>
        	<ul><li><a href="/administrative_services/officeofthepresidentprovost/organizationchart/" target="_blank">Organization Chart</a></li><li><a href="https://www.evms.edu/maps_directions_parking/" target="_blank">Campus Map</a></li><li><a href="https://myportal.evms.edu/directory/?cacheupdate=true" target="Not Set">Directory</a></li><li><a href="http://www.evms.edu/about_evms/administrative_offices/human_resources/jobs/" target="_blank">Jobs</a></li><li><a href="http://www.evms.edu" target="_blank">evms.edu</a></li><li><a href="http://evms.supportsystem.com/open.php">Website Help</a></li><li><a href="http://www.evms.edu/about_evms/campus_safety_alerts/" target="_blank">Campus Safety &amp; Alerts</a></li></ul>
		</nav>
		<p>Copyright <script type="text/javascript">
			<!--
				var currentTime = new Date();
				var year = currentTime.getFullYear();
				document.write(year);
				//-->
			</script> <br />Eastern Virginia Medical School</p>
	</div>
</footer>


<script>window.jQuery || document.write('<script src="/media/evmsprivatesite/styleassets/javascript/Media_7913_smxx.js"><\/script>')</script>
<script src="/media/evmspublic/evmsprivatedev/styleassets/javascript/responsivejs/d7916.js"></script><!-- privatedev-script.js -->
<script src="/media/evmsprivatesite/styleassets/javascript/media_7915_smxx.js"></script><!-- plugins.js -->
<!--<script src="/media/evmsprivatesite/styleassets/javascript/Media_7916_smxx.js"></script>--><!-- scripts.js -->
<!--<script src="/media/evmspublic/evmsprivatedev/styleassets/bookmarks/jquery.t4bookmarks.js"></script> t4 bookmarks -->
<?php
if(!isset($_SESSION["t4masters"])){
    echo"<script src='/media/evmspublic/evmsprivatedev/styleassets/bookmarks/jquery.t4bookmarks.js'></script><!-- t4 bookmarks -->";
}
?>
<script src="/media/evmsprivatesite/styleassets/javascript/Media_7917_smxx.js"></script><!-- jquery-ui-1.8.18.custom.min.js -->
<script src="/media/evmspublic/evmsprivatedev/styleassets/javascript/responsivejs/MP-custom.js"></script>
<script src="/media/evmsprivatesite/styleassets/javascript/additionalportal.js"></script><!-- additionalportal.js -->
  <!--insert into footer-->

<script type="text/javascript">
$(document).ready(function(){
	$(".headerBookmarks").bookmarkList({'starred':'true','limit':'5'}).show();
  	$(".listBookmarks").bookmarkList().show();
	$(".formelements").bookmarkList().fadeIn();
});
</script>
<script>
$(function() {
        $( "#datepicker" ).datepicker();
});
</script>
<script type="text/javascript">
        $(window).load(function() {
		$('.three-col-section').addClass('schedule-section').removeClass('three-col-section');
   	});
</script>
<!--Added for Site Improve Evaluation-->
    <script type="text/javascript">
/*<![CDATA[*/
(function() {
var sz = document.createElement('script'); sz.type = 'text/javascript'; sz.async = true;
sz.src = '//us1.siteimprove.com/js/siteanalyze_44561.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sz, s);
})();
/*]]>*/
</script> 
<!--End Added for Site Improve Evaluation-->

</body>
</html>

