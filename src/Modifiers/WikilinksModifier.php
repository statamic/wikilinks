<?php

namespace Statamic\Wikilinks\Modifiers;

use Illuminate\Support\Arr;
use Statamic\Facades\Entry;
use Statamic\Modifiers\Modifier;

class WikilinksModifier extends Modifier
{
    protected static $handle = 'wikilinks';

    /**
     * Maps to {{ var | wikilinks }}
     *
     * @param  mixed  $value  The value to be modified
     * @param  array  $params  Any parameters used in the modifier
     * @param  array  $context  Contextual values
     * @return mixed
     */
    public function index($value, $params, $context)
    {
        // $matches[0] -> with brackets
        // $matches[1] -> without brackets
        preg_match_all("/\[([^\]]*)\]/", $value, $matches);

        $replacements = [];
        $field = Arr::get($params, 0, 'title');
        $collection = Arr::get($params, 1, false);

        foreach ($matches[1] as $index => $query) {
            $result = Entry::query()->where($field, $query);

            if ($collection) {
                $result = $result->where('collection', $collection);
            }

            if ($result) {
                $uri = $result->first()?->uri;
                $replacements[] = ($uri) ? "<a href='{$uri}' title='{$query}'>{$query}</a>" : $query;
            } else {
                $replacements[] = $matches[0][$index];
            }
        }

        return str_replace($matches[0], $replacements, $value);
    }
}
