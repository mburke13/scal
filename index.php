<?php
session_start();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>SCal to Google</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">
  <meta property="og:title" content="SCal" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="http://scal.heuristix.me/" />
  <meta property="og:image" content="http://scal.heuristix.me/img/photo.png" />
  <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <style>
    body {
      padding-top: 50px;
      padding-bottom: 20px;
    }
  </style>
  <!--<link rel="stylesheet" href="css/bootstrap-theme.min.css">-->
  <link rel="stylesheet" href="css/chosen.min.css">
  <link rel="stylesheet" href="css/main.css">

  <script src="js/vendor/modernizr-2.6.2.min.js"></script>
</head>
<body id="about">
    <!--[if lt IE 7]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">SCal</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#about">about</a></li>
            <li><a href="#create">create</a></li>
            <li><a href="#export">export</a></li>
            <!--<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>-->
          </ul>
          <!--<form class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form>-->
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <div id="top-content">
          <h1><span class="top-text">Convert your USC course list to a Google Calendar with SCal</span><!--<img src="img/logo.gif" height="128px" width="auto"/>--></h1>
          <div id="steps">
            <p>1. Enter your courses.</p> <br />
            <p>2. Review your selections.</p> <br />
            <p>3. Export.</p>
          </div>
          <button class="btn btn-primary btn-lg" id="get-started-link" href="#create">Get Started</button> <br />
          <img src="img/calendar.png" />
        </div>
      </div>
    </div>
    <div id="create"></div>
    <div class="container" id="main">
      <div class="row">
        <div id="content" class="col-lg-4 center">
          <h3 id="select-courses"> Select Your Courses </h3>
          <ul id="semesters" class="list-inline">
            <?php
            require_once('lib/functions.php');
            $semesters = get_all_semesters();
            $size = sizeof($semesters);
            $current = $size - 1;
            if (isset($_SESSION['authorization']['calendar'])) {
              $current = array_search($_SESSION['authorization']['calendar'], $semesters);
            }
            for($i = 0; $i < $size; $i++) {
              $semester = $semesters[$i];
              $display = semester_to_string($semester);
              $id = ($i == $current) ? 'id="semester-highlighted"' : '';
              echo "<li $id class=\"semester\" data-semester-id=\"$semester\"><strong>$display</strong></li>";
            }
            ?>
          </ul>
          <hr/>
          <div role="tabpanel">

            <!-- Nav tabs -->

            <!-- Tab panes -->

          </div>
          <div role="tabpanel" class="anchor">
            <ul class="nav nav-tabs type-option" role="tablist">
              <li role="presentation" class="active"><a href="#regular-user" aria-controls="regular-user" role="tab" data-toggle="tab">Regular</a></li>
              <li role="presentation"><a href="#advanced-user" aria-controls="advanced-user" role="tab" data-toggle="tab">Advanced</a></li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="regular-user">
                <p>
                  <h4> Departments </h4>
                  <select id="departments" data-placeholder="select a department" name="departments">
                    <option value=""></option>
                    <?php
                    $depts = get_all_departments($semesters[$current]);
                    foreach($depts as $dept) {
                      $code = $dept->getCode();
                      $name = $dept->getName();
                      echo "<option value=$code>$code - $name</option>";
                    }
                    ?>
                  </select>
                  <h4> Courses </h4>
                  <select id="courses" data-placeholder="select a course" name="courses">
                    <option value=""></option>
                  </select>
                  <h4> Sections </h4>
                  <select id="sections" data-placeholder="select a section" name="sections">
                    <option value=""></option>
                  </select>
                  <br>
                  <br>
                  <a id="add-section" class="btn btn-primary btn-large" href="#" onclick="return false;">Add Course</a>
                </p>
              </div>
              <div role="tabpanel" class="tab-pane" id="advanced-user">
                <p>
                  1. Drag this button into your bookmark bar: <a class="btn btn-primary btn-large"
                  href='javascript:var res={};var semesters=["spring","summer","fall"];var semData=$(".termblock")[0].innerHTML.split(" ");var year=semData[1];var semester=semesters.indexOf(semData[0].toLowerCase())+1;res.semester=year+semester;res.sectionList=[];var sectionRows=$("#listWarp > table > tbody > tr");for(var i=1;i<sectionRows.length;++i){var sectionData={};var row=$(sectionRows[i]);var data=row.find("td");sectionData.course=data[0].innerHTML;sectionData.section=$(data[2]).text();res.sectionList.push(sectionData)}window.prompt("Copy to clipboard:",JSON.stringify(res));'>Drag Me!</a>
                </p>
                <p>2. Go to the "Calendar View" tab in Web Registration</p>
                <p>3. Click the bookmarked snippet, copy the output, and paste it below</p>
                <textarea id="sections-json" style="width: 90%;margin-bottom: 10px;"></textarea>
                <p>
                  4. <a id="add-sections" class="btn btn-primary btn-large" href="#" onclick="return false;">Add Courses</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="review">
      <h3> Review Your Courses </h3>
      <a id="load-calendar" class="btn btn-primary btn-large" href="#" onclick="return false;">Load Sections</a>
      <a id="clear-sections" class="btn btn-primary btn-large btn-group" href="#" onclick="return false;">Clear All</a>
      <div id="empty-msg">Manually add courses using the drop downs above or load a calendar
        previously made with SCal by clicking the 'Load Sections' button.</div>
        <div id="calendar">
          <div id="sections-overlay"></div>
          <table id="calendar-table">
            <tr>
              <td></td>
              <th>Monday</th>
              <th>Tuesday</th>
              <th>Wednesday</th>
              <th>Thursday</th>
              <th>Friday</th>
            </tr>
            <tr>
              <th>6:00 AM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>7:00 AM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>8:00 AM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>9:00 AM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>10:00 AM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>11:00 AM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>12:00 PM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>1:00 PM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>2:00 PM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>3:00 PM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>4:00 PM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>5:00 PM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>6:00 PM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>7:00 PM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>8:00 PM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>9:00 PM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>10:00 PM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th>11:00 PM</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </table>
        </div>
        <div id="sections">
          <ul id="my-sections" class="list-unstyled"></ul>
        </div>
        <p id="export">
          <a id="create-calendar" class="btn btn-primary btn-large btn-group" href="#"  onclick="return false;">Export</a>
          <a id="calendar-url" class="btn btn-primary btn-large" href="#" style="display: none;" target="_blank">View calendar</a>
        </p>
      </div>

      <footer>
        <hr />
        <div id="footer-content">
          <span>&copy; MMA 2013</span>
          <img class="pull-right" id="hack-sc-logo" src="img/hack-sc.jpg" />
        </div>
      </footer>
      <!-- /container -->
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
      <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

      <script src="js/vendor/bootstrap.min.js"></script>

      <script src="js/plugins.js"></script>
      <script src="js/main.js"></script>

      <script>
        var _gaq=[['_setAccount','UA-44989976-1'],['_trackPageview']];
        (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
          g.src='//www.google-analytics.com/ga.js';
          s.parentNode.insertBefore(g,s)}(document,'script'));
      </script>
    </body>
    </html>
