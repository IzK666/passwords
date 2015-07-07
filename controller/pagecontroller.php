<?php
 namespace OCA\Passwords\Controller;

 use OCP\IRequest;
 use OCP\AppFramework\Http\TemplateResponse;
 use OCP\AppFramework\Controller;
 use OCP\AppFramework\Http\ContentSecurityPolicy;

 class PageController extends Controller {

     public function __construct($AppName, IRequest $request){
         parent::__construct($AppName, $request);
     }

     /**
      * @NoAdminRequired
      * @NoCSRFRequired
      */
     public function index() {
         $response = new TemplateResponse('passwords', 'main');
         $csp = new ContentSecurityPolicy();
         $csp->addAllowedImageDomain('https://www.google.com');
         $response->setContentSecurityPolicy($csp);
         return $response;
}

 }
