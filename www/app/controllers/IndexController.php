<?php
class IndexController extends BaseController
{
    public function indexAction()
    {
        $name = $this->dispatcher->getControllerName();
        // return $this->responseJson(Error::ERR_OK, [$name]);
    }

    public function errorAction($exception)
    {
        $this->view->disable();
        $this->response->setJsonContent([
            'code' => $exception->getCode(),
            'msg' => Error::getErrMsg($exception->getCode()),
            'data' => $exception->getMessage(),
        ]);
        $this->response->send();
    }
}
