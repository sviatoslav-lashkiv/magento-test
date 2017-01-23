<?php

class TB_Testimonials_Model_Observer
{
    public function testimonialStatusMail($observer)
    {
        $testimonial = $observer->getEvent()->getTestimonial();

        $emailTemplate = Mage::getModel('core/email_template')->loadDefault('testimonial_status_tpl');

        $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');
        $senderName = Mage::getStoreConfig('trans_email/ident_general/name');

        $customerEmail = Mage::getModel('customer/customer')->load($testimonial->getCustomerId())->getEmail();
        $customerName = Mage::getModel('customer/customer')->load($testimonial->getCustomerId())->getName();

        $status = $testimonial->getStatus();
        if($status) {
            $statusMessage = "Published! <br /> Thank you for your attention.";
        } else {
            $statusMessage = "Waiting for moderation! <br /> Your testimonial will be published after moderation.";
        }

        $emailTemplateVariables = array();
        $emailTemplateVariables['name'] = $customerName;
        $emailTemplateVariables['email'] = $customerEmail;
        $emailTemplateVariables['statusMessage'] = $statusMessage;

        $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);

        $mail = Mage::getModel('core/email')
            ->setToName($customerName)
            ->setToEmail($customerEmail)
            ->setBody($processedTemplate)
            ->setSubject('Subject :')
            ->setFromEmail($senderEmail)
            ->setFromName($senderName)
            ->setType('html');
        try
        {
            $mail->send();
        }
        catch(Exception $error)
        {
            Mage::getSingleton('core/session')->addError($error->getMessage());
            return false;
        }
    }

}