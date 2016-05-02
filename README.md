Create your PDF invoices from a HTML5 template
==============================================

I wanted to create PDF invoices from a (Linux) command line without
installing a CMS. Just with data from my database tables.

So far I used Libreoffice to generate a PDF Form which I programmatically
filled out and 'flattened' using Java and the FreeForms library.

That is pretty clumsy...

HTML + CSS (+ PHP) seemed a better choice to me. Easier to understand
for non-programmers, no need to create and fill PDF Forms, just using
web standards.

I found plenty of examples on the web, they all failed in one or the other
way. It took a while to figure out all the details until I had a
satisfying - but yet not perfect - result.

I share this with you in the hope that it helps you to save some time.

The file `invoice_a4.html` is easily extendable and/or adjustable for 
your needs. It uses just a small subset of HTML5 and CSS.

View the PDF `out.pdf` by clicking on it.


What I use
----------

I work with a GNU/Linux command line (Debian SID) and just installed
`wkhtmltopdf` 0.12.3.2 and `php5` 5.6.20 (`sudo apt-get install wkhtmltopdf php5`).

To generate the PDF, just execute `./genpdf.sh`, which creates a
`out.pdf` using `php5` and `wkhtmltopdf`. This shell script is very
simple - it uses hard-coded receiver and invoice data as demonstration.

In my real shell script I query a mysql database to generate these
values.

`config.php` holds the sender data which are more static, e.g.
the name of your logo, your company, address and so on.

Have fun !
