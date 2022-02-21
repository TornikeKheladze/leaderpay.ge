<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!DOCTYPE html>
<html>
<head>
    <title>Test Liderbet Api</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="image/x-icon" href="https://img.icons8.com/fluent/48/000000/api.png">
</head>
<body>
<div class="container">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-4">
                <a href="#step-1" type="button" class="btn btn-success btn-circle" style="background-color: gray;" >1</a>
                <p><small>Check User</small></p>
            </div>
            <div class="stepwizard-step col-xs-4">
                <a href="#step-2" type="button" class="btn btn-default btn-circle" style="background-color: gray;">2</a>
                <p><small>Register Transaction</small></p>
            </div>
            <div class="stepwizard-step col-xs-4">
                <a href="#step-3" type="button" class="btn btn-default btn-circle" style="background-color: gray;">3</a>
                <p><small>Finish Transaction</small></p>
            </div>
        </div>
    </div>

    <div role="form">
        <div class="panel panel-primary setup-content" id="step-1">
            <div class="panel-heading">
                <h3 class="panel-title">Check User</h3>
            </div>
            <form action="liderbet_step_1.php" method="post">
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
                        <input id="document_number" name="document_number" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Document Number" value="19IA00262" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Pin Code</label>
                        <input id="pin_code" name="pin_code" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Pin Code" value="12345" />
                    </div>
                    <input class="btn btn-primary nextBtn pull-right" type="submit" value="Next">
                </div>
            </form>
        </div>

        <div class="panel panel-primary setup-content" id="step-2">
            <div class="panel-heading">
                <h3 class="panel-title">Register Transaction</h3>
            </div>
            <form action="liderbet_step_2.php" method="post">
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
                        <input id="personal_number" name="personal_number" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Personal Number" value="22001004341" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Document Number</label>
                        <input id="document_number" name="document_number" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Document Number" value="18ID23481"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Amount</label>
                        <input id="amount" name="amount" maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Amount" value="1" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input id="first_name" name="first_name" maxlength="200" type="text" required="required" class="form-control" placeholder="Enter First Name" value="მიხეილ" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Last Name</label>
                        <input id="last_name" name="last_name" maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Last Name" value="დემეტრაშვილი" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Birth Date</label>
                        <input id="birth_date" name="birth_date" maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Birth Date" value="1991-09-30" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Pin Code</label>
                        <input id="pin_code" name="pin_code" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Pin Code" value="57639" />
                    </div>
                    <input class="btn btn-primary nextBtn pull-right" type="submit" value="Next">
                </div>
            </form>
        </div>

        <div class="panel panel-primary setup-content" id="step-3">
            <div class="panel-heading">
                <h3 class="panel-title">Finish Transaction</h3>
            </div>
            <form action="liderbet_step_3.php" method="post">
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
                        <label class="control-label">Amount</label>
                        <input id="amount" name="amount" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Amount" value="1"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Sms Code</label>
                        <input id="sms_code" name="sms_code" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Sms Code" value="123456"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Operation ID</label>
                        <input id="operation_id" name="operation_id" maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Operation ID" value="000001" />
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


