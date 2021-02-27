<?php 
	//CLASE QUE SIRVE PARA ENVIAR CORREOS ELECTRONICOS
	require_once "../vendor/autoload.php";
	include_once '../config.ini.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	class Mailer
	{
		private $mail,$from,$from_name,$to,$to_name,$subject,$message;
		private $titulo,$mensaje;
		
		
		function enviar_correo($from,$from_name,$to,$to_name,$subject,$message)
		{
            try {
                $this->mail = new PHPMailer(true);
                $this->from = $from;
                $this->from_name = $from_name;
                $this->to = $to;
                $this->to_name = $to_name;
                $this->subject = $subject;
                $this->message = $message;


                //$this->mail->SMTPDebug = 3;
                $this->mail->isSMTP();                                            // Send using SMTP
                $this->mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $this->mail->Username   = 'milton.guzman@gmail.com';                     // SMTP username
                $this->mail->Password   = 'Moctesuma_2020';                               // SMTP password
                $this->mail->Port       = 587;

                //SENDER RECEIVER SETUP
                $this->mail->setFrom($this->from,$this->from_name);
                $this->mail->addAddress($this->to,$this->to_name);     // Add a recipient
                $this->mail->addReplyTo($this->from, 'Respuesta a asunto : '.$this->subject);
                //$this->mail->addBCC('milton@ingenio-soft.com');

                //CONTENT
                $this->mail->isHTML(true);                                  // Set email format to HTML
                $this->mail->Subject = $this->subject;
                $this->mail->Body    = $this->maquetar_correo($this->subject,$this->message) ;

                //SENDING....
                if(!$this->mail->send())
                {
                    die ("no se pudo enviar el correo");
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
                "
                    <!DOCTYPE html>
                <html lang=\"en\" xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\">
                <head>
                    <meta charset=\"utf-8\"> <!-- utf-8 works for most cases -->
                    <meta name=\"viewport\" content=\"width=device-width\"> <!-- Forcing initial-scale shouldn't be necessary -->
                    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> <!-- Use the latest (edge) version of IE rendering engine -->
                    <meta name=\"x-apple-disable-message-reformatting\">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
                    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->
                
                    <link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700\" rel=\"stylesheet\">
                    <link rel=\"stylesheet\" href=\"http://www.smartsara.co/global_assets/email.css\">
                
                </head>
                
                <body width=\"100%\" style=\"margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;\">
                <center style=\"width: 100%; background-color: #f1f1f1;\">
                    <div style=\"display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;\">
                        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
                    </div>
                    <div style=\"max-width: 600px; margin: 0 auto;\" class=\"email-container\">
                        <!-- BEGIN BODY -->
                        <table align=\"center\" role=\"presentation\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" style=\"margin: auto;\">
                            <tr>
                                <td valign=\"top\" class=\"bg_white\" style=\"padding: 1em 2.5em 0 2.5em;\">
                                    <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                                        <tr>
                                            <td class=\"logo\" style=\"text-align: center;\">
                                                <h1><a href=\"#\">Mi Plataforma de Seguro</a></h1>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr><!-- end tr -->
                            <tr>
                                <td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 3em 0 2em 0;\">
                                    <img src=\"http://www.smartsara.co/global_assets/email.png\" alt=\"\" style=\"width: 300px; max-width: 600px; height: auto; margin: auto; display: block;\">
                                </td>
                            </tr><!-- end tr -->
                            <tr>
                                <td valign=\"middle\" class=\"hero bg_white\" style=\"padding: 2em 0 4em 0;\">
                                    <table>
                                        <tr>
                                            <td>
                                                <div class=\"text\" style=\"padding: 0 2.5em; text-align: center;\">
                                                    <h2>".utf8_decode($this->titulo)."</h2>
                                                    <h4>".utf8_decode($this->mensaje)."</h4>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr><!-- end tr -->
                            <!-- 1 Column Text + Button : END -->
                        </table>
                        
                
                    </div>
                </center>
                </body>
                </html>
                ";
            return $this->message;
        }
	}

	//$test = new Mailer;
	//$test->enviar_correo('milton@ingenio-sot.com','Milton Gmail','milton.guzman@hotmail.com','Milton Hotmail','Mensaje de prueba','Este es un <b>Mensaje de prueba</b>');
