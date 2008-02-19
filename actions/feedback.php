<?php

$form = '<p>Fill in the form below to send us your comments:</p>
    <form method="post" action="'.$this->tag.'?mail=result">
    Name: <input name="name" value="'.$_POST["name"].' "type="text" /><br />
    Email: <input name="email" value="'.$_POST["email"].'" type="text" /><br />
    Comments:<br />
    <textarea name="comments" rows="15" cols="45">'.$_POST["comments"].'</textarea><br />
    <input type="submit" value="Send" />
    </form>';

if ($_GET["mail"]=="result") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $comments = $_POST["comments"];
      list($user, $host) = sscanf($email, "%[a-z0-9._-]@%[a-z0-9._-]");
    if (!$name) {
        // a valid name must be entered
        echo "<p class=\"error\">Please enter your name</p>";    
        echo $form;    
    } elseif (!$email || !strchr($email, "@") || !$user || !$host) {
        // a valid email address must be entered
        echo "<p class=\"error\">Please enter a valid email address</p>";    
        echo $form;
    } elseif (!$comments) {
        // some text must be entered
        echo "<p class=\"error\">Please enter some text</p>";    
        echo $alert;
        echo $form;
    } else {
        // send email and display message
        $msg = "Name:\t".$name."\n";
        $msg .= "Email:\t".$email."\n";
        $msg .= "\n".$comments."\n";
        $recipient = $this->GetConfigValue("admin_email");
        $subject = "Feedback from ".$this->GetConfigValue("wakka_name");
        $mailheaders = "From:".$email."\n";
        $mailheaders .= "Reply-To:".$email;
        mail($recipient, $subject, $msg, $mailheaders);
        echo $this->Format("Thanks for your interest! Your feedback has been sent to [[".$recipient."]] ---");
        echo $this->Format("Return to the [[".$this->GetConfigValue("root_page")." main page]]");
        // optionally displays the feedback text
        //echo $this->Format("---- **Name:** ".$name."---**Email:** ".$email."---**Comments:** ---".$comments);
    }    
} else {
    echo $form;
}
?> 