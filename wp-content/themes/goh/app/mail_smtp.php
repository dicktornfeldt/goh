<?php
/**
 * This function will connect wp_mail to your authenticated
 * SMTP server. This improves reliability of wp_mail, and
 * avoids many potential problems. Global variables should be defined in WP-config or .dotenv file
 */

function external_mail_smtp($phpmailer)
{
  $phpmailer->isSMTP();
  $phpmailer->Host     = SMTP_HOST;
  $phpmailer->SMTPAuth = SMTP_AUTH;
  $phpmailer->Port     = SMTP_PORT;
  $phpmailer->Username = SMTP_USER;
  $phpmailer->Password = SMTP_PASS;
  $phpmailer->From     = SMTP_FROM;
  $phpmailer->FromName = SMTP_NAME;
}

add_action('phpmailer_init', 'external_mail_smtp');
