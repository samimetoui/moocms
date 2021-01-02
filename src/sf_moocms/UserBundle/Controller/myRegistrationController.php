<?php
namespace sf_moocms\UserBundle\Controller;

use FOS\UserBundle\Controller;

class myRegistrationController extends RegistrationController {

	/**
     * @param Request $request
     *
     * @return Response
     */
    public function registerAction(Request $request)
    {

    	if($this->captchaverify($request->get('g-recaptcha-response'))) {
    		parent::registerAction( $request);
    	}

    }

    public function captchaverify($recaptcha){
            $url = "https://www.google.com/recaptcha/api/siteverify";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                "secret"=>"6LfgWMsZAAAAAJ5EIYJJXTcBv0BiJ_7ydkcauc0V","response"=>$recaptcha));
            $response = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($response);     
        
        return $data->success;        
    }
}