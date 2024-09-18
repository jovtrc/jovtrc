import Head from 'next/head';

export default function Home() {
  const links = [
    { name: 'Slides', url: 'https://docs.google.com/presentation/d/1WdN65BX9D3_QdMA5HD6V1R-e5qzd6itKS1fC2RcbD9s/edit?usp=sharing' },
    { name: 'RestPress', url: 'https://github.com/jovtrc/restpress' },
    { name: 'Brian’s Contacts', url: 'https://brianalvey.com/' },
    { name: 'João’s Contacts', url: 'https://www.joaoc.dev' },
  ];

  return (
      <div className="flex flex-col items-center justify-center min-h-screen bg-gradient-to-br from-blue-600 from-10% via-blue-900 via-40% to-stone-900 to-70%">
        <div className="w-full max-w-md px-6 py-12 text-center bg-white shadow-lg rounded-lg">
          <h1 className="mt-4 text-xl font-bold text-gray-800">Breaking News:<br/>CNN’s Rise to Industry Leader in Brazil
          </h1>
          <p className="mt-2 text-gray-600">Presentation links</p>

          <div className="mt-6 space-y-4">
            {links.map((link, index) => (
                <a
                    key={index}
                    href={link.url}
                    rel="noopener noreferrer"
                    className="block px-4 py-2 text-lg font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-600"
                >
                  {link.name}
                </a>
            ))}
          </div>
        </div>
      </div>
  );
}
