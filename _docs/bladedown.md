# Markdown

> Normal Blockquote

>info Info Blockquote

>warning Warning Blockquote

>danger Danger Blockquote

>success Success Blockquote


```php
// Filepath: Hello.php

// Foo
echo 'Hello World';

$example = "bar";
```


```php
// Filepath: Hello.php
// Foo
echo 'Hello World';

$example = "bar";
```

```markdown
// Filepath: _docs\bladedown.md

# Hello World
```

```yaml
# filepath test.yml

hello: world
- foo: "bar"
```


```yaml
# filepath nothingelsehere.yml
```

```markdown
 > Normal Blockquote

 >info Info Blockquote
 >warning Warning Blockquote
 >danger Danger Blockquote
 >success Success Blockquote
```



````markdown
// Filepath: _docs\markdown-features.md

# Automatic Filepaths!

You can now add a filepath to your code blocks
using semantic comments right in your code examples!

Example:
```markdown
// Filepath: _docs\markdown-features.md // HYDE! {"shortcodes": false} HYDE! // 

# Automatic Filepaths! 
[...]
```
````
