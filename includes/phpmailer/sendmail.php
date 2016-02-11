<?php

date_default_timezone_set('Etc/UTC');
header('Content-Type: text/html; charset=utf-8');

require_once('PHPMailerAutoload.php');
require_once('class.phpmailer.php');
require_once('../../includes/classes/core.php');

$sent_mail_id 	 	= $_REQUEST['source_id'];
$incomming_call_id	= $_REQUEST['incomming_call_id'];

$mail_shabl_id      = $_REQUEST['mail_shabl_id'];
$address 			= $_REQUEST['address'];
$cc_address 		= $_REQUEST['cc_address'];
$bcc_address 		= $_REQUEST['bcc_address'];
$subject 	 		= $_REQUEST['subject'];
$body 	 			= $_REQUEST['body'];
$user               = $_SESSION['USERID'];

$signature          = '';

$res  = mysql_query("SELECT	concat('../../media/uploads/file/',rand_name) AS `rand_name`
                    FROM 	`file`
                    JOIN	send_mail_detail ON send_mail_detail.file_id = file.id
                    JOIN   sent_mail ON sent_mail.id = send_mail_detail.sent_mail_id
                    WHERE	send_mail_detail.sent_mail_id = $sent_mail_id AND status=1");
                    
$res1  = mysql_query("SELECT	concat('../../media/uploads/file/',rand_name) AS `rand_name`
                    FROM 	`file`
                    WHERE	mail_id = $mail_shabl_id");

if($user == 7){
    $user_mail = "akaki@carekids.ge";
}elseif($user == 8){
    $user_mail = "natia@carekids.ge";
}
//Create a new PHPMailer instance
$mail = new PHPMailer;
// Set PHPMailer to use the sendmail transport
$mail->isSendmail();
//Set who the message is to be sent from
$mail->setFrom($user_mail, 'Carekids.ge');
//Set an alternative reply-to address
$mail->addReplyTo($user_mail, 'Carekids.ge');
// Set who the message is to be sent to
// $mail->addAddress('papalashvilidato@gmail.com', 'dato');
// //Set the subject line
// $mail->Subject = 'PHPMailer sendmail test';
// //Read an HTML message body from an external file, convert referenced images to embedded,
// //convert HTML into a basic plain-text alternative body
// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
// //Replace the plain text body with one created manually
// $mail->AltBody = 'This is a plain-text message body';
// //Attach an image file
// $mail->addAttachment('images/phpmailer_mini.png');

$mail->addAddress($address);

$mail->AddCC($bcc_address);

$mail->AddBCC($cc_address);
$mail->IsHTML(true);

$mail->Subject = $subject;

$mail->Body = 'შეთანხმებისამებრ, გიგზავნით პრეზენტაციას (იხ. მიმაგრებული ფაილი).
<br>
ჩვენი ვებ-გვერდის სანახავად, მიჰყევით ლინკს:
<br>
http://carekids.ge/index.php?opid=agent1
<br>

პატივისცემით,
<p class="MsoNormal" style="margin-bottom: 12pt;"><b><span helvetica","sans-serif";mso-fareast-font-family:"times="" new="" roman";mso-no-proof:="" yes"="">Akaki<span style="color: rgb(49, 163, 188);">&nbsp;</span></span></b><br><b><span times="" new="" roman";="" color:#31a3bc;mso-no-proof:yes"="" style="font-size: 10pt;">Sales</span></b><span times="" new="" roman";mso-no-proof:yes"="" style="font-size: 10pt;">&nbsp;<span style="font-weight: bold;">Coordinator</span><o:p></o:p></span></p><p class="MsoNormal" style="margin-bottom: 12pt;"><b><span style="font-size: 10pt; color: rgb(49, 163, 188);">Adress:&nbsp;</span></b><span style="font-size: 13.3333px;">Politkovskaia A. 10, 0186, Tbilisi, Georgia</span></p><p class="MsoNormal" style="margin-bottom: 12pt;"><b><span style="font-size: 10pt; color: rgb(49, 163, 188);">Phone: &nbsp;</span></b><span style="font-size: 13.3333px;">032 2 500 055</span></p><p class="MsoNormal" style="margin-bottom: 12pt;"><b><span style="font-size: 10pt; color: rgb(49, 163, 188);">Mobile:&nbsp;</span></b><span style="font-size: 13.3333px;">577 62 61 16</span></p><p class="MsoNormal" style="margin-bottom: 12pt;"><b><span style="font-size: 10pt; color: rgb(49, 163, 188);">e-mail:&nbsp;</span></b><span times="" new="" roman";mso-no-proof:="" yes"="" style="font-size: 10pt;"><a href="mailto:akaki@carekids.ge">a_meparishvili@carekids.ge</a><o:p></o:p></span></p><p class="MsoNormal" style="margin-bottom: 12pt;"></p><p class="MsoNormal" style="margin-bottom: 12pt;"><br></p>';

$mail->CharSet="UTF-8";

while ($row = mysql_fetch_assoc($res)) {

    $mail->addAttachment($row[rand_name]);

}

while ($row1 = mysql_fetch_assoc($res1)) {

    $mail->addAttachment($row1[rand_name]);

}


//send the message, check for errors
if (!$mail->send()) {
    //echo "Mailer Error: " . $mail->ErrorInfo;
    $status				= 'false';
    $data 				= array("status" => $status);
    
    $user	  			= $_SESSION['USERID'];
    $c_date	  			= date('Y-m-d H:i:s');
    
    mysql_query("UPDATE `sent_mail`
        SET 	`user_id`='$user',
        `date`='$c_date',
        `address`='$address',
        `cc_address`='$cc_address',
        `bcc_address`='$bcc_address',
        `subject`='$subject',
        `body`='$body',
        `status`='3'
        WHERE 	`id`=$sent_mail_id;
        ");
} else {
    //echo "Message sent!";
    $status				= 'true';
    $data 				= array("status" => $status);
    
    $user	  			= $_SESSION['USERID'];
    $c_date	  			= date('Y-m-d H:i:s');
    
    $res_check=mysql_query("SELECT sent_mail.id
        FROM sent_mail
        WHERE sent_mail.id=$sent_mail_id");
    if (mysql_num_rows($res_check)==0) {
        mysql_query("INSERT INTO
            `sent_mail`
            (`incomming_call_id`, `user_id`, `date`, `address`, `cc_address`, `bcc_address`, `subject`, `body`, `status`, `actived`)
            VALUES
            ('$incomming_call_id', '1', NOW(), '$address', '$cc_address', '$bcc_address', '$subject', '$body', '2', '1');");
    }else{
        mysql_query("UPDATE `sent_mail`
            SET
            `user_id`='$user',
            `date`=NOW(),
            `address`='$address',
            `cc_address`='$cc_address',
            `bcc_address`='$bcc_address',
            `subject`='$subject',
            `body`='$body',
            `status`='2'
            WHERE 	`id`=$sent_mail_id;
            ");
    
    }
}
echo json_encode($data);