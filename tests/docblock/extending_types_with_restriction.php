<?php

interface Job {}

class SendEmailJob implements Job {}
class CreatePdfJob implements Job {}

function takesSendEmailJob(SendEmailJob $job): void {}
function takesCreatePdfJob(CreatePdfJob $job): void {}


/** @template T of Job */
interface JobProcessor
{
    /** @return class-string<T> */
    public function supports(): string;

    /** @param T $job */
    public function process($job): void;
}


/** @implements JobProcessor<SendEmailJob> */
class EmailSenderJobProcessor implements JobProcessor
{
    public function supports(): string
    {
        return SendEmailJob::class;
    }

    public function process($job): void
    {
        takesSendEmailJob($job); // OK
        takesCreatePdfJob($job); // ERROR. Expecting CreatePdfJob got SendEmailJob
    }
}

$emailSenderJobProcessor = new EmailSenderJobProcessor();
$emailSenderJobProcessor->process(new SendEmailJob()); // OK
$emailSenderJobProcessor->process(new CreatePdfJob()); // ERROR. Expected SendEmailJob got CreatePdfJob
