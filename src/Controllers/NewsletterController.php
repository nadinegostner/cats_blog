<?php


namespace App\Controllers;


use Slim\Views\Twig;

class NewsletterController
{
    protected $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function newsletter($request, $response, $args)
    {
        return $this->view->render($response, 'newsletter.twig');
    }

    public function subscribe($request, $response){
       /*  $email = $request->getParam('email');
        $firstname = $request->getParam('firstname');
        $lastname = $request->getParam('lastname');
        $list_id = '73484788f4';
        $api_key = '9e0c956798a39f6f9cff9760f3c24bb0-us3';

        $data_center = substr($api_key, strpos($api_key, '-') + 1);

        $url = 'https://' . $data_center . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members';

        $json = json_encode([
            'email_address' => $email,
            'status'        => 'subscribed', //pass 'subscribed' or 'pending'
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $api_key);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo $status_code; */
    }
}