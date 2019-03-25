<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/16
 * Time: 19:03
 */

namespace app\blog\controller;


use app\blog\model\BlogComment;
use app\common\controller\Common;
use PHPMailer\PHPMailer\PHPMailer;
use think\Exception;
use think\Log;

class Comment extends Common
{
    public function index()
    {
        $param = $this->request->param();
        $where = array();
        if (isset($param['type']) and is_numeric($param['type'])) {
            $where['a.article_id'] = $param['type'];
        }
        if (isset($param['status']) and is_numeric($param['status'])) {
            $where['a.status'] = $param['status'];
        }
        $model = new BlogComment();
        $this->assign('menu',$model->getLast($where));
        return $this->fetch();
    }

    public function review()
    {
        $id = $this->request->param('id');
        $comment = BlogComment::get($id);
        $this->assign('comment',$comment);
        return $this->fetch();
    }

    public function reply()
    {
        if ($this->request->isAjax()) {
            $param = $this->request->param();
            $mail = new PHPMailer();
            try {
                $toemail = $param['email'];//收件人
                $mail->isSMTP();// 使用SMTP服务
                $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
                $mail->Host = "smtp.163.com";// 发送方的SMTP服务器地址
                $mail->SMTPAuth = true;// 是否使用身份验证
                $mail->Username = "19767@163.com";/// 发送方的163邮箱用户名，就是你申请163的SMTP服务使用的163邮箱
                $mail->Password = "Hackmayi00";// 发送方的邮箱密码，注意用163邮箱这里填写的是“客户端授权密码”而不是邮箱的登录密码！
                $mail->SMTPSecure = "ssl";// 使用ssl协议方式
                $mail->Port = 465;// 163邮箱的ssl协议方式端口号是465/994
                $mail->setFrom("19767@163.com","佩晨博客");// 设置发件人信息，如邮件格式说明中的发件人，这里会显示为Mailer(xxxx@163.com），Mailer是当做名字显示
                $mail->addAddress($toemail);// 设置收件人信息，如邮件格式说明中的收件人，这里会显示为Liang(yyyy@163.com)
                $mail->addReplyTo("19767@163.com","佩晨博客");// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
                $mail->Subject = "Pc回复";// 邮件标题
                $mail->Body = "{$param['contents']}";// 邮件正文
                if (!$mail->send()) {
                    //Log::write($param['email'].'邮件发送失败');
                    throw new Exception($mail->ErrorInfo);
                }
            } catch (Exception $e) {
                return json(array('code'=>0,'msg'=>$e->getMessage()));
            }
            return json(array('code'=>1,'msg'=>'回复成功'));
        } else {
            return json(array('code'=>0,'msg'=>'请求方式错误'));
        }
    }

    public function check()
    {
        $model = new BlogComment();
        return $this->changeStatus($model->getTable(),'status','1');
    }

    public function delete()
    {
        $model = new BlogComment();
        return $this->remove($model->getTable());
    }
}