<?php

namespace LaravelTarva\Fields;

use LaravelTarva\Http\Requests\MainRequests\Resource\ResourceFormRequest;
use Illuminate\Database\Eloquent\Model;

class Wysiwyg extends Field
{
    protected array $headings = [];
    protected bool $bold = true;
    protected bool $italic = true;
    protected bool $underline = true;
    protected bool $strike = false;
    protected bool $bulletList = true;
    protected bool $orderedList = true;
    protected int $maxInputLength = 20000;
    protected array $additionalCssFiles = [];

    public function __construct($name, $attribute)
    {
        parent::__construct($name, $attribute);
        $this->hideFromIndex();
    }

    /**
     * Set heading classes
     *
     * @param array $headings
     * @return self
     */
    public function headings(array $headings): self {
        $this->headings = array_unique(
            array_filter($headings, fn ($heading) => in_array($heading, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6']))
        );
        return $this;
    }

    /**
     * Set bold
     *
     * @param bool $bold
     * @return self
     */
    public function bold(bool $bold): self {
        $this->bold = $bold;
        return $this;
    }

    /**
     * Set italic
     *
     * @param bool $italic
     * @return self
     */
    public function italic(bool $italic): self {
        $this->italic = $italic;
        return $this;
    }

    /**
     * Set underline
     *
     * @param bool $underline
     * @return self
     */
    public function underline(bool $underline): self {
        $this->underline = $underline;
        return $this;
    }

    /**
     * Set strike
     *
     * @param bool $strike
     * @return self
     */
    public function strike(bool $strike): self {
        $this->strike = $strike;
        return $this;
    }

    /**
     * Set bullet list
     *
     * @param bool $bulletList
     * @return self
     */
    public function bulletList(bool $bulletList): self {
        $this->bulletList = $bulletList;
        return $this;
    }

    /**
     * Set ordered list
     *
     * @param bool $orderedList
     * @return self
     */
    public function orderedList(bool $orderedList): self {
        $this->orderedList = $orderedList;
        return $this;
    }

    /**
     * Set max input length
     *
     * @param int $maxInputLength
     * @return self
     */
    public function maxInputLength(int $maxInputLength): self {
        $this->maxInputLength = $maxInputLength;
        return $this;
    }

    /**
     * Set additional css files to load
     * [data-prosemirror="my-field"] to style
     *
     * @param array $additionalCssFiles
     * @return self
     */
    public function additionalCssFiles(array $additionalCssFiles): self {
        $this->additionalCssFiles = $additionalCssFiles;
        return $this;
    }

    /**
     * Fill model value from request
     *
     * @param Model $model
     * @param ResourceFormRequest $request
     * @return void
     */
    public function fillValue(Model $model, ResourceFormRequest $request): void
    {
        if(is_callable($this->fillCallback)) {
            call_user_func($this->fillCallback, $model, $request);
            return;
        }
        if(!$request->exists($this->attribute)) return;

        $value = $request->get($this->attribute);
        if(is_callable($this->sanitizeCallback)) {
            $value = call_user_func($this->sanitizeCallback, $value);
        } else {
            $extensions = ['basic'];
            if($this->bulletList || $this->orderedList) {
                array_push($extensions, 'list');
            }
            $sanitizer = \HtmlSanitizer\Sanitizer::create([
                'max_input_length' => $this->maxInputLength,
                'extensions' => $extensions,
                'tags' => [
                    'abbr' => [
                        'allowed_attributes' => [],
                    ],
                    'a' => [
                        'allowed_attributes' => ['href', 'title'],
                        'allowed_hosts' => null,
                        'allow_mailto' => true,
                        'force_https' => false,
                    ],
                    'blockquote' => [
                        'allowed_attributes' => [],
                    ],
                    'br' => [
                        'allowed_attributes' => [],
                    ],
                    'caption' => [
                        'allowed_attributes' => [],
                    ],
                    'code' => [
                        'allowed_attributes' => [],
                    ],
                    'dd' => [
                        'allowed_attributes' => [],
                    ],
                    'del' => [
                        'allowed_attributes' => [],
                    ],
                    'details' => [
                        'allowed_attributes' => ['open'],
                    ],
                    'div' => [
                        'allowed_attributes' => [],
                    ],
                    'dl' => [
                        'allowed_attributes' => [],
                    ],
                    'dt' => [
                        'allowed_attributes' => [],
                    ],
                    'em' => [
                        'allowed_attributes' => [],
                    ],
                    'figcaption' => [
                        'allowed_attributes' => [],
                    ],
                    'figure' => [
                        'allowed_attributes' => [],
                    ],
                    'h1' => [
                        'allowed_attributes' => [],
                    ],
                    'h2' => [
                        'allowed_attributes' => [],
                    ],
                    'h3' => [
                        'allowed_attributes' => [],
                    ],
                    'h4' => [
                        'allowed_attributes' => [],
                    ],
                    'h5' => [
                        'allowed_attributes' => [],
                    ],
                    'h6' => [
                        'allowed_attributes' => [],
                    ],
                    'hr' => [
                        'allowed_attributes' => [],
                    ],
                    'iframe' => [
                        'allowed_attributes' => ['src', 'width', 'height', 'frameborder', 'title', 'allow', 'allowfullscreen'],
                        'allowed_hosts' => null,
                        'force_https' => false,
                    ],
                    'img' => [
                        'allowed_attributes' => ['src', 'alt', 'title'],
                        'allowed_hosts' => null,
                        'allow_data_uri' => false,
                        'force_https' => false,
                    ],
                    'i' => [
                        'allowed_attributes' => [],
                    ],
                    'li' => [
                        'allowed_attributes' => [],
                    ],
                    'ol' => [
                        'allowed_attributes' => [],
                    ],
                    'pre' => [
                        'allowed_attributes' => [],
                    ],
                    'p' => [
                        'allowed_attributes' => [],
                    ],
                    'q' => [
                        'allowed_attributes' => [],
                    ],
                    'rp' => [
                        'allowed_attributes' => [],
                    ],
                    'rt' => [
                        'allowed_attributes' => [],
                    ],
                    'ruby' => [
                        'allowed_attributes' => [],
                    ],
                    'small' => [
                        'allowed_attributes' => [],
                    ],
                    'span' => [
                        'allowed_attributes' => [],
                    ],
                    'strong' => [
                        'allowed_attributes' => [],
                    ],
                    'sub' => [
                        'allowed_attributes' => [],
                    ],
                    'summary' => [
                        'allowed_attributes' => [],
                    ],
                    'sup' => [
                        'allowed_attributes' => [],
                    ],
                    'table' => [
                        'allowed_attributes' => [],
                    ],
                    'tbody' => [
                        'allowed_attributes' => [],
                    ],
                    'td' => [
                        'allowed_attributes' => [],
                    ],
                    'tfoot' => [
                        'allowed_attributes' => [],
                    ],
                    'thead' => [
                        'allowed_attributes' => [],
                    ],
                    'th' => [
                        'allowed_attributes' => [],
                    ],
                    'tr' => [
                        'allowed_attributes' => [],
                    ],
                    'u' => [
                        'allowed_attributes' => [],
                    ],
                    'ul' => [
                        'allowed_attributes' => [],
                    ],
                ]
            ]);
            $value = $sanitizer->sanitize($value);
        }
        $model->{$this->attribute} = $value;
    }

    /**
     * Serialize field for forms
     * 
     * @return array
     */
    public function serializeForForms() {
        return array_merge(parent::serializeForForms(), [
            'additionalCssFiles' => $this->additionalCssFiles,
            'headings' => $this->headings,
            'bold' => $this->bold,
            'italic' => $this->italic,
            'underline' => $this->underline,
            'strike' => $this->strike,
            'bulletList' => $this->bulletList,
            'orderedList' => $this->orderedList,
        ]);
    }

    /**
     * Serialize field for details
     * 
     * @return array
     */
    public function serializeForDetail() {
        return array_merge(parent::serializeForForms(), [
            'additionalCssFiles' => $this->additionalCssFiles,
        ]);
    }
}
