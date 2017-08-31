<?php
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 kasa-pointa" onclick="registerSchool()">
                <h2>Register Institution</h2>

                <p>Click Here To Register Your School On The TSC Portal</p>
            </div>

            <div class="col-lg-4 kasa-pointa" onclick="registerClasses()">
                <h2>Select Classes</h2>

                <p>Click Here To Register Your Classes On The TSC Portal</p>
            </div>

            <div class="col-lg-4 kasa-pointa" onclick="registerSubjects()">
                <h2>Register Subjects</h2>

                <p>Click Here To Register Subjects Offered In Your School On The TSC Portal</p>
            </div>

            <div class="col-lg-4 kasa-pointa" onclick="registerTeacher()">
                <h2>Register Teachers</h2>

                <p>Click Here To Register Teachers In Your School On The TSC Portal</p>
            </div>
        </div>

    </div>
</div>
