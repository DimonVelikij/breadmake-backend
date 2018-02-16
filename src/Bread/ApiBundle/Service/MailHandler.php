<?php

namespace Bread\ApiBundle\Service;

use Symfony\Bundle\TwigBundle\TwigEngine;

class MailHandler
{
    /** @var \Swift_Mailer  */
    private $mailer;

    /** @var TwigEngine  */
    private $templating;

    /** @var array  */
    private $options;

    /**
     * MailHandler constructor.
     * @param \Swift_Mailer $mailer
     * @param TwigEngine $templating
     * @param array $options
     */
    public function __construct(
        \Swift_Mailer $mailer,
        TwigEngine $templating,
        array $options
    ) {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->options = $options;
    }

    /**
     * @param $object
     * @param $to
     * @param $subject
     * @param $templateName
     * @return int
     */
    public function send(
        $object,
        $to,
        $subject,
        $templateName
    ) {
        $message = \Swift_Message::newInstance();
        $message
            ->setSubject($subject)
            ->setCharset('UTF8')
            ->setFrom([$this->options['from'] => $this->options['user_title']])
            ->setTo($to)
            ->setBody($this->templating->render('@BreadContent/Mail/' . $templateName . '.html.twig', $object), 'text/html');

        return $this->mailer->send($message);
    }
}