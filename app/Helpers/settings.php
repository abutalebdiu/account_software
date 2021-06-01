<?php


    /*
    |-------------------------------------
    | Merchant Login Otp Activate
    |-------------------------------------
    */

    function merchantLoginOtpActivateStatus_HS()
    {
        return 1;
    }

    function merchantLoginOptExpireTime_HS()
    {
        return 1;
        // merchant login expire otp time 
    }

    function merchantLoginOptExpireTimeType_HS()
    {
        return 'minutes';
        // merchant login expire otp time type , minutes, seconds , //hour , hour is not allowed
    }






    /*
    |-------------------------------------
    | Merchant Login Username and password
    |-------------------------------------
    */
    function merchantLoginByUsernameFieldInUserMethod_HS()
    {
    	return "phone";
    }

    function merchantLoginByPasswordFieldInasPasswordMethod_HS()
    {
    	return "password";
    }

    function merchantAfterLoginOptFieldNullActivateMethod_HS()
    {
    	return 1;
    }

    function merchantAfterLoginPasswordFieldNullActivateMethod_HS()
    {
    	return 1;
    }


    function merchantLoginOtpExpireTimeActivateMethod_HS()
    {
        return 0;
    }



    /*
    |-------------------------------------
    | Manpower Login Username and password
    |-------------------------------------
    */
    function manpowerLoginByUsernameFieldInUserMethod_HS()
    {
    	return "email";
    }

    function manpowerLoginByPasswordFieldInasPasswordMethod_HS()
    {
    	return "password";
    }