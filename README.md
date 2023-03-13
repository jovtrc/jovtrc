```php
<?php
namespace JoaoCarvalho;

class About extends Me
{
    public function getPersonalInfo(): array
    {
        return [
            'name'     => 'João Carvalho',
            'position' => 'Senior Software Engineer',
            'location' => 'São Paulo, Brazil 🇧🇷',
            'website'  => 'https://joaoc.dev'
        ];
    }
    public function getSkills(): array
    {
        return [
            'languages'  => ['JavaScript', 'PHP'],
            'frameworks' => ['React', 'React Native', 'Laravel', 'WordPress'],
            'databases'  => ['MySQL', 'PostgreSQL', 'Fauna']
        ];
    }
}
```

---

You can reach me via [Linkedin](https://www.linkedin.com/in/jovtrc/) and follow me at @joaocarvalho.cc on [Instagram](https://www.instagram.com/joaocarvalho.cc)
