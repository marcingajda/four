<?php

declare(strict_types=1);

namespace Bolt\Entity\Field;

use Bolt\Entity\Field;
use Bolt\Utils\Str;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SlugField extends Field
{
    public function setValue(array $value): parent
    {
        $value = Str::slug(reset($value));
        $this->value = [$value];

        return $this;
    }

    public function getSlugPrefix()
    {
        // @todo https://github.com/bolt/four/issues/188 allow empty slug prefix
        $content = $this->getContent();

        if (! $content) {
            //@todo remove this
            return '/foobar/';
        }

        return sprintf('/%s/', $content->getDefinition()->get('singular_slug'));
    }

    public function getSlugUseFields()
    {
        return (array) $this->getDefinition()->get('uses');
    }
}
