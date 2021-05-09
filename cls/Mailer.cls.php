<?php 
	//CLASE QUE SIRVE PARA ENVIAR CORREOS ELECTRONICOS

	include_once '../config.ini.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    require_once "../vendor/autoload.php";
	class Mailer
	{
		private $mail,$from,$from_name,$to,$to_name,$subject,$message;
		private $titulo,$mensaje;


		function enviar_correo($from,$from_name,$to,$to_name,$subject,$message)
		{
            try {
                $this->mail = new PHPMailer(true);
                //AQUI LA DIRECCION DE CORREO DEL SERVIDOR
                $this->from = 'farmaenlace@ingenio-soft.com';
                $this->from_name = $from_name." : ".$from;
                $this->to = $to;
                $this->to_name = $to_name;
                $this->subject = $subject;
                $this->message = $message;


                //$this->mail->SMTPDebug = 3;
                $this->mail->isSMTP();                                            // Send using SMTP
                $this->mail->Host       = 'mail.ingenio-soft.com';                    // Set the SMTP server to send through
                $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $this->mail->Username   = 'farmaenlace@ingenio-soft.com';                     // SMTP username
                $this->mail->Password   = 'Farmaenlace_2021';                               // SMTP password
                $this->mail->SMTPSecure = "tls";
                $this->mail->Port       = 26;
                $this->mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                //SENDER RECEIVER SETUP
                $this->mail->setFrom($this->from,$this->from_name);
                $this->mail->addAddress($this->to,$this->to_name);     // Add a recipient
                $this->mail->addReplyTo($this->from, 'Respuesta a asunto : '.$this->subject);
                $this->mail->addBCC('farmaenlace@ingenio-soft.com');

                //CONTENT
                $this->mail->isHTML(true);                                  // Set email format to HTML
                $this->mail->Subject = $this->subject;
                $this->mail->Body    = $this->maquetar_correo($this->subject,$this->message) ;
                //SENDING....
                if(!$this->mail->send())
                {
                    die ("Error : no se pudo enviar el correo");
                }


            }
            catch (Exception $e)
            {
                echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            }

		}
		private  function maquetar_correo($titulo,$mensaje)
        {
            $this->titulo = $titulo;
            $this->mensaje = $mensaje;
            $this->message =
                "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">

<head>
	<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
	<meta name=\"viewport\" content=\"width=device-width\">
	<!--[if !mso]><!-->
	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
	<!--<![endif]-->
	<title></title>
	<!--[if !mso]><!-->
	<!--<![endif]-->
	<style type=\"text/css\">
            body {
            margin: 0;
            padding: 0;
        }

		table,
		td,
		tr {
            vertical-align: top;
			border-collapse: collapse;
		}

		* {
            line-height: inherit;
		}

		a[x-apple-data-detectors=true] {
            color: inherit !important;
			text-decoration: none !important;
		}
	</style>
	<style type=\"text/css\" id=\"media-query\">
            @media (max-width: 520px) {

            .block-grid,
			.col {
                min-width: 320px !important;
				max-width: 100% !important;
				display: block !important;
			}

			.block-grid {
                width: 100% !important;
            }

			.col {
                width: 100% !important;
            }

			.col_cont {
                margin: 0 auto;
			}

			img.fullwidth,
			img.fullwidthOnMobile {
                max-width: 100% !important;
			}

			.no-stack .col {
                min-width: 0 !important;
				display: table-cell !important;
			}

			.no-stack.two-up .col {
                width: 50% !important;
            }

			.no-stack .col.num2 {
                width: 16.6% !important;
            }

			.no-stack .col.num3 {
                width: 25% !important;
            }

			.no-stack .col.num4 {
                width: 33% !important;
            }

			.no-stack .col.num5 {
                width: 41.6% !important;
            }

			.no-stack .col.num6 {
                width: 50% !important;
            }

			.no-stack .col.num7 {
                width: 58.3% !important;
            }

			.no-stack .col.num8 {
                width: 66.6% !important;
            }

			.no-stack .col.num9 {
                width: 75% !important;
            }

			.no-stack .col.num10 {
                width: 83.3% !important;
            }

			.video-block {
                max-width: none !important;
			}

			.mobile_hide {
                min-height: 0px;
				max-height: 0px;
				max-width: 0px;
				display: none;
				overflow: hidden;
				font-size: 0px;
			}

			.desktop_hide {
                display: block !important;
				max-height: none !important;
			}
		}
	</style>
</head>

<body class=\"clean-body\" style=\"margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #FFFFFF;\">
	<!--[if IE]><div class=\"ie-browser\"><![endif]-->
	<table class=\"nl-container\" style=\"table-layout: fixed; vertical-align: top; min-width: 320px; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF; width: 100%;\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" width=\"100%\" bgcolor=\"#FFFFFF\" valign=\"top\">
		<tbody>
			<tr style=\"vertical-align: top;\" valign=\"top\">
				<td style=\"word-break: break-word; vertical-align: top;\" valign=\"top\">
					<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color:#FFFFFF\"><![endif]-->
					<div style=\"background-color:#ffffff;\">
						<div class=\"block-grid \" style=\"min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;\">
							<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:transparent;\">
								<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:#ffffff;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:500px\"><tr class=\"layout-full-width\" style=\"background-color:transparent\"><![endif]-->
								<!--[if (mso)|(IE)]><td align=\"center\" width=\"500\" style=\"background-color:transparent;width:500px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
								<div class=\"col num12\" style=\"min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;\">
									<div class=\"col_cont\" style=\"width:100% !important;\">
										<!--[if (!mso)&(!IE)]><!-->
										<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
											<!--<![endif]-->
											<div class=\"img-container center autowidth\" align=\"center\" style=\"padding-right: 0px;padding-left: 0px;\">
												<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]--><img class=\"center autowidth\" align=\"center\" border=\"0\" src=\"http://ingenio-soft.com/sources/logo-farmaenlace.png\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 337px; display: block;\" width=\"337\">
												<!--[if mso]></td></tr></table><![endif]-->
											</div>
											<table cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" width=\"100%\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;\" valign=\"top\">
												<tr style=\"vertical-align: top;\" valign=\"top\">
													<td style=\"word-break: break-word; vertical-align: top; padding-bottom: 0px; padding-left: 0px; padding-right: 0px; padding-top: 0px; text-align: center; width: 100%;\" width=\"100%\" align=\"center\" valign=\"top\">
														<h2 style=\"color:#262b80;direction:ltr;font-family:Verdana, Geneva, sans-serif;font-size:26px;font-weight:normal;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;\"><strong>".utf8_decode($this->titulo)."</strong></h2>
													</td>
												</tr>
											</table>
											<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Verdana, sans-serif\"><![endif]-->
											<div style=\"color:#393d47;font-family:Verdana, Geneva, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
												<div class=\"txtTinyMce-wrapper\" style=\"line-height: 1.2; font-size: 12px; color: #393d47; font-family: Verdana, Geneva, sans-serif; mso-line-height-alt: 14px;\">
													<p style=\"margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: justify; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;\">".$this->mensaje."</p>
												</div>
											</div>
											<!--[if mso]></td></tr></table><![endif]-->
											<!--[if (!mso)&(!IE)]><!-->
										</div>
										<!--<![endif]-->
									</div>
								</div>
								<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
								<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
							</div>
						</div>
					</div>
					<div style=\"background-color:transparent;\">
						<div class=\"block-grid \" style=\"min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;\">
							<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:transparent;\">
								<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:500px\"><tr class=\"layout-full-width\" style=\"background-color:transparent\"><![endif]-->
								<!--[if (mso)|(IE)]><td align=\"center\" width=\"500\" style=\"background-color:transparent;width:500px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
								<div class=\"col num12\" style=\"min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;\">
									<div class=\"col_cont\" style=\"width:100% !important;\">
										<!--[if (!mso)&(!IE)]><!-->
										<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
											<!--<![endif]-->
											<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Verdana, sans-serif\"><![endif]-->
											<div style=\"color:#393d47;font-family:Verdana, Geneva, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
												<div class=\"txtTinyMce-wrapper\" style=\"line-height: 1.2; font-size: 12px; color: #393d47; font-family: Verdana, Geneva, sans-serif; mso-line-height-alt: 14px;\">
													<p style=\"margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;\">Desarrollo y Soporte <a href=\"http://www.peefcorporation.com/\" target=\"_blank\" title=\"Peef Corp\" style=\"text-decoration: none; color: #8a3b8f;\" rel=\"noopener\">Peef Corp</a> | <a href=\"https://ingenio-soft.com/\" target=\"_blank\" title=\"Ingenio-soft\" style=\"text-decoration: underline; color: #8a3b8f;\" rel=\"noopener\">Ingenio-soft</a> 2021</p>
												</div>
											</div>
											<!--[if mso]></td></tr></table><![endif]-->
											<!--[if (!mso)&(!IE)]><!-->
										</div>
										<!--<![endif]-->
									</div>
								</div>
								<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
								<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
							</div>
						</div>
					</div>
					<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
				</td>
			</tr>
		</tbody>
	</table>
	<!--[if (IE)]></div><![endif]-->
</body>

</html>";
            return $this->message;
        }
	}

	//$test = new Mailer();
	//$test->enviar_correo('farmaenlace@ingenio-soft.com','Farmaenlace','milton.guzman@gmail.com','Milton Gmail','Mensaje de prueba','Este es un <b>Mensaje de prueba</b>');
