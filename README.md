```php
<?php
namespace JoaoCarvalho;

class About extends Me
{
    public function getPersonalInfo(): array
    {
        return [
            'name'     => 'João Carvalho',
            'position' => 'Software Architect',
            'location' => 'São Paulo, Brazil 🇧🇷',
            'website'  => 'https://joaoc.dev'
        ];
    }
    public function getSkills(): array
    {
        return [
            'languages'  => ['JavaScript/TypeScript', 'PHP'],
            'frameworks' => ['React', 'React Native', 'Laravel', 'WordPress', 'Nest.js', 'Next.js'],
            'databases'  => ['MySQL', 'PostgreSQL', 'Firestore']
        ];
    }
}
```

---

You can reach me via [Linkedin](https://www.linkedin.com/in/jovtrc/) and follow me at @joaocarvalho.cc on [Instagram](https://www.instagram.com/joaocarvalho.cc)
