import Image from "next/image";
import { GitHubLogoIcon, LinkedInLogoIcon, InstagramLogoIcon } from "@radix-ui/react-icons";
import Link from "next/link";

export default function Home() {
  return (
    <main className="
      w-full antialiased
      lg:bg-gradient-to-br
      from-blue-600 from-10% via-blue-900 via-40% to-stone-900 to-70%
    ">
      <div className="
        flex flex-col mx-auto
        lg:flex-row lg:h-screen lg:justify-center lg:items-center lg:gap-8 lg:w-10/12 xl:w-7/12
      ">
        <header
          className="
            font-inriaSerif flex flex-col items-center text-center py-16
            lg:w-5/12
            lg:mt-0 lg:flex lg:flex-col lg:justify-center
            bg-gradient-to-br from-blue-600 from-10% via-blue-900 via-40% to-stone-900 to-70%
            lg:bg-none
          "
        >
          <h1 className="relative text-shadow shadow-neutral-950/[.75]">
            <span className="uppercase font-inter block text-sm">
              Software Engineer & Professor
            </span>

            <span className="text-5xl tracking-tighter">
              João Carvalho
            </span>
          </h1>

          <Image
            src="https://github.com/jovtrc.png"
            alt="João Carvalho"
            width="294"
            height="294"
            className="block rounded-full -mt-4 "
          />

          <ul className="flex gap-6 mt-6">
            <li>
              <Link href="https://github.com/jovtrc/">
                <GitHubLogoIcon width="32" height="32" />
              </Link>
            </li>
            <li>
              <Link href="https://www.linkedin.com/in/jovtrc/">
                <LinkedInLogoIcon width="32" height="32" />
              </Link>
            </li>
            <li>
              <Link href="https://www.instagram.com/joaocarvalho.cc/">
                <InstagramLogoIcon width="32" height="32" />
              </Link>
            </li>
          </ul>
        </header>

        <section className="
            bg-neutral-950 px-7 py-10 rounded-t-2xl -mt-8 space-y-6
            lg:mt-0 lg:flex lg:flex-col lg:justify-center lg:w-7/12 lg:p-10 lg:rounded-2xl
        ">
          <h2 className="text-3xl font-black">About.</h2>

          <p>João Carvalho is a software engineer and educator with a decade of experience in WordPress and software development. He is currently the Technical Leader at CNN Brazil and a Postgraduate Professor at FIAP, one of Brazil’s best technology universities.</p>

          <p>Before joining CNN, he worked as a Software Engineer at Wikimedia Foundation and other major Media brands in Brazil.</p>

          <p>When he is not at his keyboard, João can be found traveling through Brazil on his motorcycle or searching for the best ice cream in the world.!</p>
        </section>
      </div>
    </main>
  );
}
