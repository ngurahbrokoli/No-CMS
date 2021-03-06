<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style type="text/css">
    #message:not(:empty){
        background-color:#FFCACA;
	    padding: 5px 5px 5px 5px;
	    margin : 10px;
	    font-size: small;
	    min-height : 25px;
	    border-radius:5px;
	    -moz-border-radius:5px;
	    -moz-box-shadow:    1px 1px 5px 6px #ccc;
	    -webkit-box-shadow: 1px 1px 5px 6px #ccc;
	    box-shadow:         1px 1px 5px 6px #ccc;      
        max-width : 400px;
    }
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/nocms/js/jquery.js"></script>
<script type="text/javascript">
    function check_user_exists(){
        var user_name =  $('input[name="user_name"]').val();
        var password = $('input[name="password"]').val();
        var confirm_password = $('input[name="confirm_password"]').val();
        $.ajax({
            "url" : "check_change_profile",
            "type" : "POST",
            "data" : {"user_name":user_name},
            "dataType" : "json",
            "success" : function(data){
                if(!data.exists && user_name!='' && password!='' && password==confirm_password){
                    $('input[name="change_profile"]').show();
                    $('input[name="change_profile"]').removeAttr('disabled');                    
                }else{
                    $('input[name="change_profile"]').hide();
                    $('input[name="change_profile"]').attr('disabled', 'disabled');
                }
                
                // get message from server + local check
                var message = '';
                if(data.message!=''){
                    message += data.message+'<br />';
                }
                if(password == ''){
                    message += 'Password is empty<br />';
                }
                if(password != confirm_password){
                    message += 'Confirm password doesn\'t match';
                }
                
                if(message != $('#message').html()){
                    $('#message').html(message);                    
                }
            }
        });
    }
    
    $(document).ready(function(){
        check_user_exists();
        $('input').keyup(function(){
            check_user_exists();
        });
    })
</script> 

<?php
    echo form_open('main/change_profile');
    echo form_label('User Name').br();
    echo form_input('user_name', $user_name).br();
    echo form_label('E mail').br();
    echo form_input('email', $email).br();
    echo form_label('Real Name').br();
    echo form_input('real_name', $real_name).br();
    echo form_label('Password').br();
    echo form_password('password').br();
    echo form_label('Confirm Password').br();
    echo form_password('confirm_password').br();    
    echo form_submit('change_profile', 'Change Profile');
    echo form_close();
?>
<div id="message"></div>
