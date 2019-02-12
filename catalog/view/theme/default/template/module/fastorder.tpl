<?php echo $header; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>

<div id="content">
	<?php echo $content_top; ?>

	<?php if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHttpRequest') {
            $body = "<b>Быстрый заказ продукта:</b>
                <a href='" . $_POST['url'] . "'>" . $_POST['product'] . "</a><br/>
                <p><b>Имя: </b>" . $_POST['name'] . "</p>
                <p><b>Тел: </b>" . $_POST['phone'] . "</p>
                <p><b>E-mail: </b>" . $_POST['email'] . "</p>";
            $body = html_entity_decode($body, ENT_QUOTES, 'UTF-8');
		    // $from_email = (!empty($_POST['email'])) ? $_POST['email'] : 'notreply@' . $_SERVER['SERVER_NAME'];
			// $headers = array('From' => $from_email,'FromName' => 'Быстрый заказ с сайта');
			/* Для отправки HTML-почты вы можете установить шапку Content-type. */
			// $headers = "От: " . $_POST['name'] . "  <" . $from_email . "><br/>";
            $subject = $this->config->get('config_name') . '. Быстрый заказ продукта: ' . $_POST['product'] . '; Имя: ' . $_POST['name'] . '; Тел: ' . $_POST['phone'] . '; E-mail: ' . $_POST['email'];
            $subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');

			// $headers  = iconv('UTF-8', 'windows-1251', $headers);
			// $subject = iconv('UTF-8', 'windows-1251', $subject);
			// mail($email, $subject, $body, $headers);
			
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');         
            $mail->setTo($this->config->get('config_email'));
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject($subject);
            $mail->setHtml($body);
            $mail->setText($body);
            $mail->send();

            if ($_POST['email']) {
                $body .= "<br /> " . $_POST['name'] . ", cпасибо за Ваш заказ.<br /> Мы свяжемся с Вами в ближайшее время.";
                $body = html_entity_decode($body, ENT_QUOTES, 'UTF-8');

                $mail->setTo($_POST['email']);
                $mail->setFrom($this->config->get('config_email'));
                $mail->setSender($this->config->get('config_name'));
                $mail->setSubject($subject);
                $mail->setHtml($body);
                $mail->setText($body);
                $mail->send();
            }

			/*Отправка покупателю */
			// if ($_POST['email']) {
			// 	$subject1 = 'Быстрый заказ продукта - '.$_POST['product'].' принят в обработку';
			// 	$subject1 = iconv('UTF-8', 'windows-1251', $subject1);
   //              $body1 = $body."<br /> Спасибо за Ваш заказ.<br /> Мы свяжемся с Вами в ближайшее время.";
			// 	$body1 = iconv('UTF-8', 'windows-1251', $body1);
			// 	$headers1 = array('From'=>'notreply@'.$_SERVER['SERVER_NAME'],'FromName'=>'Заказ товара '.$_POST['product'].' принят');
			// 	$headers1 = implode('\r\n', $headers1);
			// 	$headers1 .= "MIME-Version: 1.0\r\n";
			// 	$headers1 .= "Content-type: text/html; charset=windows-1251\r\n";
			// 	$headers1 .= "From: Заказ товара  <notreply@".$_SERVER['SERVER_NAME'].">\r\n";
			// 	$headers1  = iconv('UTF-8', 'windows-1251', $headers1);
			// 	mail($_POST['email'], $subject1, $body1, $headers1);
		 //    }
	} ?>
<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>