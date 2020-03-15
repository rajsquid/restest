<?php


namespace Restest\Application;

//use Restest\Domain\Helper\HelperParameter;
use Restest\Domain\Presentation\Presentations;
use Restest\Domain\Repository\Repositories;
use Restest\Domain\Process;

class ApplicationProcess extends HttpResources
{
    /**
     * @return ApplicationProcess
     */
    public static function instance()
    {
        return new ApplicationProcess();
    }

    /**
     * @SWG\Delete(
     *        path="/process/{id}", summary="Delete a process by id", description="",
     * @SWG\Response(response=204, description="")
     * )
     */
    public function delete($req, $res, $args)
    {
        Repositories::instance()->forProcess()->delete($args["id"]);

        return $this->response($res, static::STATUS_NO_CONTENT);
    }

    /**
     * @SWG\Get(
     *        path="/process/{id}", summary="Get a process by id", description="",
     * @SWG\Response(response=200, description="")
     * )
     */
    public function get($req, $res, $args)
    {
        $process = Repositories::instance()->forProcess()->get($args["id"]);

        $user_id = $process['user_id'];
        $user = Repositories::instance()->forUser()->get($user_id);
        $process['user_id'] = Presentations::instance()->forUser()->inJson($user);

        $contract_id = $process['contract_id'];
        $contract = Repositories::instance()->forContract()->get($contract_id);
        $process['contract_id'] = Presentations::instance()->forContract()->inJson($contract);

        return $this->response($res, static::STATUS_OK, $process);
    }


    /**
     * @SWG\Get(
     *        path="/processes", summary="Get all processes", description="",
     * @SWG\Response(response=200, description="")
     * )
     */
    public function getAll($req, $res, $args)
    {
        $processes = Repositories::instance()->forProcess()->getAll();

        for($i = 0; $i < count($processes); $i++) {
            $user_id = $processes[$i]['user_id'];
            $user = Repositories::instance()->forUser()->get($user_id);
            $processes[$i]['user_id'] = Presentations::instance()->forUser()->inJson($user);

            $contract_id = $processes[$i]['contract_id'];
            $contract = Repositories::instance()->forContract()->get($contract_id);
            $processes[$i]['contract_id'] = Presentations::instance()->forContract()->inJson($contract);
        }

        return $this->response($res, static::STATUS_OK, $processes);
    }

    /**
     * @SWG\Post(
     *        path="/proassign", summary="Create a process assign relationship with contract", description="",
     * @SWG\Parameter(name="user_id", in="formData", required=true, type="string", description="UserID"),
     * @SWG\Parameter(name="contract_id", in="formData", required=true, type="integer", description="ContractID"),
     * @SWG\Response(response=201, description="")
     * )
     */
    public function post($req, $res, $args)
    {
        $process = new Process();

        $user_id = $req->getParam("user_id");
        $user = Repositories::instance()->forUser()->get($user_id);
        $contract_id = $req->getParam("contract_id");
        $contract = Repositories::instance()->forContract()->get($contract_id);

        $process->setUser(empty($user_id) ? null : $user);
        $process->setContract(empty($contract_id) ? null : $contract);

        $data = array('contract_id' => $contract->getId('id'), 'user_id' => $user->getId('id'));
        $process_id = Repositories::instance()->forProcess()->insert($data);

        $data['process_id'] = (int)$process_id;
        $data['user_id'] = Presentations::instance()->forUser()->inJson($user);
        $data['contract_id'] = Presentations::instance()->forContract()->inJson($contract);

        return $this->response(
            $res, static::STATUS_CREATED,
            $data
        );
    }
}