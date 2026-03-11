<?php
namespace Probe\Support;

use Probe\Support\Auth\Enums\HttpErrorResponseCode;
use Probe\Support\Auth\Enums\HttpResponseCode;
use Probe\Support\Traits\Stringable;

class JSONResponse{
    use Stringable;
    protected array $body = [];

    public function __toString(): string{
        header('Content-Type: application/json; charset=utf-8');
        return JSON::encode([
            "code" => $this->responseCode->value,
            "message" => $this->message,
            ...$this->body
        ]);
    }
    /**
     * Create a JSON Response object.
     * @param HttpResponseCode|HttpErrorResponseCode $responseCode
     * @param string $message
     * @param array $body An array that will be appended after the code and message keys in the JSON response.
     */
    public function __construct(protected HttpResponseCode|HttpErrorResponseCode $responseCode = HttpResponseCode::OK, protected string $message = "no message provided", array $body = []){
        // Remove the code and message key from the body to prevent conflicts with $responseCode and $message
        $this->body = array_remove_keys(array: $body, keys: ["code", "message"]);
    }
}