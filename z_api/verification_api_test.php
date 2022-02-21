<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!DOCTYPE html>
<html>
<head>
    <title>Test Verification Api</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="image/x-icon" href="https://img.icons8.com/fluent/48/000000/api.png">
</head>
<body>
<div class="container">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-4">
                <a href="#step-1" type="button" class="btn btn-success btn-circle" style="background-color: gray;" >1</a>
                <p><small>User</small></p>
            </div>
            <div class="stepwizard-step col-xs-4">
                <a href="#step-2" type="button" class="btn btn-default btn-circle" style="background-color: gray;">2</a>
                <p><small>Document</small></p>
            </div>
            <div class="stepwizard-step col-xs-4">
                <a href="#step-3" type="button" class="btn btn-default btn-circle" style="background-color: gray;">3</a>
                <p><small>Finish</small></p>
            </div>
        </div>
    </div>

    <div role="form">
        <div class="panel panel-primary setup-content" id="step-1">
            <div class="panel-heading">
                <h3 class="panel-title">User</h3>
            </div>
            <form action="verification_step_1.php" method="post">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label">Agen ID</label>
                        <input id="agent_id" name="agent_id" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Agent ID" value="31"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Cashbox ID</label>
                        <input id="cashbox_id" name="cashbox_id" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Cashbox ID" value="68"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Country</label>
                        <input id="country" name="country" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Country" value="GE" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Personal Number</label>
                        <input id="personal_number" name="personal_number" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Personal Number" value="38001046884" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Document Number</label>
                        <input id="document_number" name="document_number" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Document Number" value="19IA00262" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input id="first_name" name="first_name" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name" value="davit" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Last Name</label>
                        <input id="last_name" name="last_name" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" value="kifshidze" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Birth Date</label>
                        <input id="birth_date" name="birth_date" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Birth Date" value="1999-04-25"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Mobile</label>
                        <input id="mobile" name="mobile" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Mobile" value="598250452"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input id="email" name="email" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Email" value="datokifshidze@gmail.com"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Sfero</label>
                        <input id="sfero" name="sfero" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Sfero" value="program"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Birth Place</label>
                        <input id="birth_place" name="birth_place" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Birth Place" value="saqartvelo"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Real Address</label>
                        <input id="real_address" name="real_address" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Real Address" value="tbilisi"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Gender</label>
                        <input id="gender" name="gender" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Gender" value="1"/>
                    </div>
                    <input class="btn btn-primary nextBtn pull-right" type="submit" value="Next">
                </div>
            </form>
        </div>
        <!--STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP -->
        <!--STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP -->
        <!--STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP -->
        <!--STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP -->

        <div class="panel panel-primary setup-content" id="step-2">
            <div class="panel-heading">
                <h3 class="panel-title">Document</h3>
            </div>
            <form action="verification_step_2.php" method="post">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label">Agen ID</label>
                        <input id="agent_id" name="agent_id" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Agent ID" value="31"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Cashbox ID</label>
                        <input id="cashbox_id" name="cashbox_id" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Cashbox ID" value="68"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Personal Number</label>
                        <input id="personal_number" name="personal_number" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Personal Number" value="38001046884" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Document Number</label>
                        <input id="document_number" name="document_number" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Document Number" value="19IA00262"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Document Type</label>
                        <input id="document_type" name="document_type" maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Document Type" value="2"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Issue Organisation</label>
                        <input id="issue_organisation" name="issue_organisation" maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Issue Organisation" value="იუსტიციის სამინისტრო"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Country</label>
                        <input id="country" name="country" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Country" value="GE" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Issue Date</label>
                        <input id="issue_date" name="issue_date" maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Issue Date" value="2019-07-29" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Expire Date</label>
                        <input id="expiry_date" name="expiry_date" maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Expire Date" value="2029-07-29" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Expire</label>
                        <input id="expire" name="expire" maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Expire" value="0"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Document Front</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFileLang" lang="es">
                            <label class="custom-file-label" for="customFileLang">Select Document Front</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Document Front</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFileLang" lang="es">
                            <label class="custom-file-label" for="customFileLang">Select Document Front</label>
                        </div>
                    </div>
                    <input class="btn btn-primary nextBtn pull-right" type="submit" value="Next">
                </div>
            </form>
        </div>

        <!--STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP -->
        <!--STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP -->
        <!--STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP -->
        <!--STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP STEP -->

        <div class="panel panel-primary setup-content" id="step-3">
            <div class="panel-heading">
                <h3 class="panel-title">Finish</h3>
            </div>
            <form action="verification_step_3.php" method="post">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label">Agen ID</label>
                        <input id="agent_id" name="agent_id" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Agent ID" value="31"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Cashbox ID</label>
                        <input id="cashbox_id" name="cashbox_id" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Cashbox ID"  value="68"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Personal Number</label>
                        <input id="personal_number" name="personal_number" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Personal Number" value="38001046884"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Document Number</label>
                        <input id="document_number" name="document_number" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Document Number" value="19IA00262"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Document</label>
                        <div class="custom-file">
                            <input type="file" required="required" class="custom-file-input" id="customFileLang" lang="es">
                            <label class="custom-file-label" for="customFileLang">Select Document</label>
                        </div>
                    </div>
                    <input class="btn btn-primary nextBtn pull-right" type="submit" value="Next">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<script src="test.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


