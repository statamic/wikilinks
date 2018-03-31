<?php

namespace Statamic\Addons\Wikilinks;
use Statamic\API\Search;
use Statamic\API\Content;
use Statamic\Extend\Modifier;

class WikilinksModifier extends Modifier
{
    /**
     * Maps to {{ var | wikilinks }}
     *
     * @param mixed  $value    The value to be modified
     * @param array  $params   Any parameters used in the modifier
     * @param array  $context  Contextual values
     * @return mixed
     */
    public function index($value, $params, $context)
    {
        // $matches[0] -> with brackets
        // $matches[1] -> without brackets
        preg_match_all("/\[([^\]]*)\]/", $value, $matches);

        $replacements = [];

        $field = array_get($params, 0, 'title');

        foreach($matches[1] as $index => $query) {
            if ($result = Search::get($query, [$field])) {

                $id = array_get($result->first(), 'id');
                $url = Content::find($id)->url();

                $replacements[] = ($url) ? "<a href='{$url}'>{$query}</a>" : $query;
            }
        }
        return str_replace($matches[0], $replacements, $value);
    }
}
