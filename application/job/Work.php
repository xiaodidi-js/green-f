<?php
namespace app\job;

use think\queue\Job;
class Work{
	public function fire(Job $job, $data){
		$time = time();
		//....这里执行具体的任务 
		echo "123";
		if ($job->attempts() > 3) {
			//通过这个方法可以检查这个任务已经重试了几次了
		}
		/*$obo = new xxxxmodle();
		$resule = $obo->sendOrder($data);
		if ($result['status']) {
			$job->delete();
		} else{
		// $job->release(); //$delay为延迟时间
		}*/
		//如果任务执行成功后 记得删除任务，不然这个任务会重复执行，直到达到最大重试次数后失败后，执行failed方法
		
		// 也可以重新发布这个任务
	
	}
	
	public function failed($data){
		// ...任务达到最大重试次数后，失败了
	}

}
