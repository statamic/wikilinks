## Installing

- Install by copying the files into `site/addons/Wikilinks`.
- That's it.

## Usage

Wikilinks is a simple modifier that seeks out any content wrapped in [braces] and automatically links it to other entries or pages with the same title (or other field of your choosing).

### Example

Let's assume we have a collection full of entries about people, one of whom is named Jerry.

```.language-yaml
content_field: It's been a long time since I've seen [Jerry].
```

```
{{ content_field | markdown | wikilinks }}
```

```.language-output
<p>It's been a long time since I've seen <a href="/people/jerry">Jerry</a>.</p>
```

### Parameters

By default Wikilinks will match by the `title` field, but you can pass another field as a parameter. Be sure to choose a field that exists in your search index.

**Example:**
```
{{ content_field | markdown | wikilinks:author }}
```
