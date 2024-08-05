import type { Metadata } from "next";
import { Inter, Playfair, Inria_Serif, Inria_Sans } from "next/font/google";
import "./globals.css";

const inter = Inter({
  subsets: ["latin"],
  variable: "--font-inter"
});
const inriaSerif = Inria_Serif({
  subsets: ["latin"],
  variable: "--font-inriaSerif",
  weight: ["400"]
});

export const metadata: Metadata = {
  title: "João Carvalho | Personal Page",
  description: "João Carvalho is a software engineer and educator with a decade of experience in WordPress and software development",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <body className={`${inter.variable} ${inriaSerif.variable} bg-neutral-950 text-neutral-100`}>{children}</body>
    </html>
  );
}
