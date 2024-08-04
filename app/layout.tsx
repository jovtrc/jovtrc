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
  title: "Create Next App",
  description: "Generated by create next app",
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
