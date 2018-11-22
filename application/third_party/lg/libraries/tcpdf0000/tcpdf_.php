<?php

//============================================================+

// File name   : tcpdf.php

// Begin       : 2002-08-03

// Last Update : 2009-05-23

// Author      : Nicola Asuni - info@tecnick.com - http://www.tcpdf.org

// Version     : 4.6.012

// License     : GNU LGPL (http://www.gnu.org/copyleft/lesser.html)

// 	----------------------------------------------------------------------------

//  Copyright (C) 2002-2009  Nicola Asuni - Tecnick.com S.r.l.

// 	

// 	This program is free software: you can redistribute it and/or modify

// 	it under the terms of the GNU Lesser General Public License as published by

// 	the Free Software Foundation, either version 2.1 of the License, or

// 	(at your option) any later version.

// 	

// 	This program is distributed in the hope that it will be useful,

// 	but WITHOUT ANY WARRANTY; without even the implied warranty of

// 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

// 	GNU Lesser General Public License for more details.

// 	

// 	You should have received a copy of the GNU Lesser General Public License

// 	along with this program.  If not, see <http://www.gnu.org/licenses/>.

// 	

// 	See LICENSE.TXT file for more information.

//  ----------------------------------------------------------------------------

//

// Description : This is a PHP class for generating PDF documents without 

//               requiring external extensions.

//

// NOTE:

// This class was originally derived in 2002 from the Public 

// Domain FPDF class by Olivier Plathey (http://www.fpdf.org), 

// but now is almost entirely rewritten.

//

// Main features:

//  * no external libraries are required for the basic functions;

// 	* supports all ISO page formats;

// 	* supports custom page formats, margins and units of measure;

// 	* supports UTF-8 Unicode and Right-To-Left languages;

// 	* supports TrueTypeUnicode, OpenTypeUnicode, TrueType, OpenType, Type1 and CID-0 fonts;

// 	* supports document encryption;

// 	* includes methods to publish some XHTML code;

// 	* includes graphic (geometric) and transformation methods;

// 	* includes Javascript and forms support;

// 	* includes a method to print various barcode formats: CODE 39, ANSI MH10.8M-1983, USD-3, 3 of 9, CODE 93, USS-93, Standard 2 of 5, Interleaved 2 of 5, CODE 128 A/B/C, 2 and 5 Digits UPC-Based Extention, EAN 8, EAN 13, UPC-A, UPC-E, MSI, POSTNET, PLANET, RMS4CC (Royal Mail 4-state Customer Code), CBC (Customer Bar Code), KIX (Klant index - Customer index), Intelligent Mail Barcode, Onecode, USPS-B-3200, CODABAR, CODE 11, PHARMACODE, PHARMACODE TWO-TRACKS;

// 	* includes methods to set Bookmarks and print a Table of Content;

// 	* includes methods to move and delete pages;

// 	* includes methods for automatic page header and footer management;

// 	* supports automatic page break;

// 	* supports automatic page numbering and page groups;

// 	* supports automatic line break and text justification;

// 	* supports JPEG and PNG images natively, all images supported by GD (GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM) and all images supported via ImagMagick (http://www.imagemagick.org/www/formats.html)

// 	* supports stroke and clipping mode for text;

// 	* supports clipping masks;

// 	* supports Grayscale, RGB, CMYK, Spot Colors and Transparencies;

// 	* supports several annotations, including links, text and file attachments;

// 	* supports page compression (requires zlib extension);

//  * supports text hyphenation.

//  * supports transactions to UNDO commands.

//

// -----------------------------------------------------------

// THANKS TO:

// 

// Olivier Plathey (http://www.fpdf.org) for original FPDF.

// Efthimios Mavrogeorgiadis (emavro@yahoo.com) for suggestions on RTL language support.

// Klemen Vodopivec (http://www.fpdf.de/downloads/addons/37/) for Encryption algorithm.

// Warren Sherliker (wsherliker@gmail.com) for better image handling.

// dullus for text Justification.

// Bob Vincent (pillarsdotnet@users.sourceforge.net) for <li> value attribute.

// Patrick Benny for text stretch suggestion on Cell().

// Johannes Güntert for JavaScript support.

// Denis Van Nuffelen for Dynamic Form.

// Jacek Czekaj for multibyte justification

// Anthony Ferrara for the reintroduction of legacy image methods.

// Sourceforge user 1707880 (hucste) for line-trough mode.

// Larry Stanbery for page groups.

// Martin Hall-May for transparency.

// Aaron C. Spike for Polycurve method.

// Mohamad Ali Golkar, Saleh AlMatrafe, Charles Abbott for Arabic and Persian support.

// Moritz Wagner and Andreas Wurmser for graphic functions.

// Andrew Whitehead for core fonts support.

// Esteban Joël Marín for OpenType font conversion.

// Teus Hagen for several suggestions and fixes.

// Yukihiro Nakadaira for CID-0 CJK fonts fixes.

// Kosmas Papachristos for some CSS improvements.

// Marcel Partap for some fixes.

// Won Kyu Park for several suggestions, fixes and patches.

// Anyone that has reported a bug or sent a suggestion.

//============================================================+



/**

 * This is a PHP class for generating PDF documents without requiring external extensions.<br>

 * TCPDF project (http://www.tcpdf.org) was originally derived in 2002 from the Public Domain FPDF class by Olivier Plathey (http://www.fpdf.org), but now is almost entirely rewritten.<br>

 * <h3>TCPDF main features are:</h3>

 * <ul>

* <li>no external libraries are required for the basic functions;</li>

* <li>supports all ISO page formats;</li>

* <li>supports custom page formats, margins and units of measure;</li>

* <li>supports UTF-8 Unicode and Right-To-Left languages;</li>

* <li>supports TrueTypeUnicode, OpenTypeUnicode, TrueType, OpenType, Type1 and CID-0 fonts;</li>

* <li>supports document encryption;</li>

* <li>includes methods to publish some XHTML code;</li>

* <li>includes graphic (geometric) and transformation methods;</li>

* <li>includes Javascript and forms support;</li>

* <li>includes a method to print various barcode formats: CODE 39, ANSI MH10.8M-1983, USD-3, 3 of 9, CODE 93, USS-93, Standard 2 of 5, Interleaved 2 of 5, CODE 128 A/B/C, 2 and 5 Digits UPC-Based Extention, EAN 8, EAN 13, UPC-A, UPC-E, MSI, POSTNET, PLANET, RMS4CC (Royal Mail 4-state Customer Code), CBC (Customer Bar Code), KIX (Klant index - Customer index), Intelligent Mail Barcode, Onecode, USPS-B-3200, CODABAR, CODE 11, PHARMACODE, PHARMACODE TWO-TRACKS;</li>

* <li>includes methods to set Bookmarks and print a Table of Content;</li>

* <li>includes methods to move and delete pages;</li>

* <li>includes methods for automatic page header and footer management;</li>

* <li>supports automatic page break;</li>

* <li>supports automatic page numbering and page groups;</li>

* <li>supports automatic line break and text justification;</li>

* <li>supports JPEG and PNG images natively, all images supported by GD (GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM) and all images supported via ImagMagick (http://www.imagemagick.org/www/formats.html)</li>

* <li>supports stroke and clipping mode for text;</li>

* <li>supports clipping masks;</li>

* <li>supports Grayscale, RGB, CMYK, Spot Colors and Transparencies;</li>

* <li>supports several annotations, including links, text and file attachments;</li>

* <li>supports page compression (requires zlib extension);</li>

* <li>supports text hyphenation.</li>

* <li>supports transactions to UNDO commands.</li>

 * </ul>

 * Tools to encode your unicode fonts are on fonts/utils directory.</p>

 * @package com.tecnick.tcpdf

 * @abstract Class for generating PDF files on-the-fly without requiring external extensions.

 * @author Nicola Asuni

 * @copyright 2002-2009 Nicola Asuni - Tecnick.com S.r.l (www.tecnick.com) Via Della Pace, 11 - 09044 - Quartucciu (CA) - ITALY - www.tecnick.com - info@tecnick.com

 * @link http://www.tcpdf.org

 * @license http://www.gnu.org/copyleft/lesser.html LGPL

 * @version 4.6.012

 */



/**

 * main configuration file

 */

require_once(dirname(__FILE__).'/config/tcpdf_config.php');



// includes some support files



/**

 * unicode data

 */

require_once(dirname(__FILE__).'/unicode_data.php');



/**

 * html colors table

 */

require_once(dirname(__FILE__).'/htmlcolors.php');



if (!class_exists('TCPDF', false)) {

	/**

	 * define default PDF document producer

	 */ 

	define('PDF_PRODUCER', 'TCPDF 4.6.012 (http://www.tcpdf.org)');

	

	/**

	* This is a PHP class for generating PDF documents without requiring external extensions.<br>

	* TCPDF project (http://www.tcpdf.org) has been originally derived in 2002 from the Public Domain FPDF class by Olivier Plathey (http://www.fpdf.org), but now is almost entirely rewritten.<br>

	* @name TCPDF

	* @package com.tecnick.tcpdf

	* @version 4.6.012

	* @author Nicola Asuni - info@tecnick.com

	* @link http://www.tcpdf.org

	* @license http://www.gnu.org/copyleft/lesser.html LGPL

	*/

	class TCPDF {

		

		// protected or Protected properties



		/**

		* @var current page number

		* @access protected

		*/

		protected $page;

		

		/**

		* @var current object number

		* @access protected

		*/

		protected $n;



		/**

		* @var array of object offsets

		* @access protected

		*/

		protected $offsets;



		/**

		* @var buffer holding in-memory PDF

		* @access protected

		*/

		protected $buffer;



		/**

		* @var array containing pages

		* @access protected

		*/

		protected $pages = array();



		/**

		* @var current document state

		* @access protected

		*/

		protected $state;



		/**

		* @var compression flag

		* @access protected

		*/

		protected $compress;

		

		/**

		* @var current page orientation (P = Portrait, L = Landscape)

		* @access protected

		*/

		protected $CurOrientation;



		/**

		* @var array that stores page dimensions and graphic status.<ul><li>$this->pagedim[$this->page]['w'] => page_width_in_points</li><li>$this->pagedim[$this->page]['h'] => height in points</li><li>$this->pagedim[$this->page]['wk'] => page_width_in_points</li><li>$this->pagedim[$this->page]['hk'] => height</li><li>$this->pagedim[$this->page]['tm'] => top_margin</li><li>$this->pagedim[$this->page]['bm'] => bottom_margin</li><li>$this->pagedim[$this->page]['lm'] => left_margin</li><li>$this->pagedim[$this->page]['rm'] => right_margin</li><li>$this->pagedim[$this->page]['pb'] => auto_page_break</li><li>$this->pagedim[$this->page]['or'] => page_orientation</li><li>$this->pagedim[$this->page]['olm'] => original_left_margin</li><li>$this->pagedim[$this->page]['orm'] => original_right_margin</li></ul>

		* @access protected

		*/

		protected $pagedim = array();



		/**

		* @var scale factor (number of points in user unit)

		* @access protected

		*/

		protected $k;



		/**

		* @var width of page format in points

		* @access protected

		*/

		protected $fwPt;



		/**

		* @var height of page format in points

		* @access protected

		*/

		protected $fhPt;



		/**

		* @var current width of page in points

		* @access protected

		*/

		protected $wPt;



		/**

		* @var current height of page in points

		* @access protected

		*/

		protected $hPt;



		/**

		* @var current width of page in user unit

		* @access protected

		*/

		protected $w;



		/**

		* @var current height of page in user unit

		* @access protected

		*/

		protected $h;



		/**

		* @var left margin

		* @access protected

		*/

		protected $lMargin;



		/**

		* @var top margin

		* @access protected

		*/

		protected $tMargin;



		/**

		* @var right margin

		* @access protected

		*/

		protected $rMargin;



		/**

		* @var page break margin

		* @access protected

		*/

		protected $bMargin;



		/**

		* @var cell internal padding

		* @access protected

		*/

		//protected

		public $cMargin;

		

		/**

		* @var cell internal padding (previous value)

		* @access protected

		*/

		protected $oldcMargin;



		/**

		* @var current horizontal position in user unit for cell positioning

		* @access protected

		*/

		protected $x;



		/**

		* @var current vertical position in user unit for cell positioning

		* @access protected

		*/

		protected $y;



		/**

		* @var height of last cell printed

		* @access protected

		*/

		protected $lasth;



		/**

		* @var line width in user unit

		* @access protected

		*/

		protected $LineWidth;



		/**

		* @var array of standard font names

		* @access protected

		*/

		protected $CoreFonts;



		/**

		* @var array of used fonts

		* @access protected

		*/

		protected $fonts = array();



		/**

		* @var array of font files

		* @access protected

		*/

		protected $FontFiles = array();



		/**

		* @var array of encoding differences

		* @access protected

		*/

		protected $diffs = array();



		/**

		* @var array of used images

		* @access protected

		*/

		protected $images = array();



		/**

		* @var array of Annotations in pages

		* @access protected

		*/

		protected $PageAnnots = array();



		/**

		* @var array of internal links

		* @access protected

		*/

		protected $links = array();



		/**

		* @var current font family

		* @access protected

		*/

		protected $FontFamily;



		/**

		* @var current font style

		* @access protected

		*/

		protected $FontStyle;

		

		/**

		* @var current font ascent (distance between font top and baseline)

		* @access protected

		* @since 2.8.000 (2007-03-29)

		*/

		protected $FontAscent;

		

		/**

		* @var current font descent (distance between font bottom and baseline)

		* @access protected

		* @since 2.8.000 (2007-03-29)

		*/

		protected $FontDescent;



		/**

		* @var underlining flag

		* @access protected

		*/

		protected $underline;



		/**

		* @var current font info

		* @access protected

		*/

		protected $CurrentFont;



		/**

		* @var current font size in points

		* @access protected

		*/

		protected $FontSizePt;



		/**

		* @var current font size in user unit

		* @access protected

		*/

		protected $FontSize;



		/**

		* @var commands for drawing color

		* @access protected

		*/

		protected $DrawColor;



		/**

		* @var commands for filling color

		* @access protected

		*/

		protected $FillColor;



		/**

		* @var commands for text color

		* @access protected

		*/

		protected $TextColor;



		/**

		* @var indicates whether fill and text colors are different

		* @access protected

		*/

		protected $ColorFlag;



		/**

		* @var automatic page breaking

		* @access protected

		*/

		protected $AutoPageBreak;



		/**

		* @var threshold used to trigger page breaks

		* @access protected

		*/

		protected $PageBreakTrigger;



		/**

		* @var flag set when processing footer

		* @access protected

		*/

		protected $InFooter = false;



		/**

		* @var zoom display mode

		* @access protected

		*/

		protected $ZoomMode;



		/**

		* @var layout display mode

		* @access protected

		*/

		protected $LayoutMode;



		/**

		* @var title

		* @access protected

		*/

		protected $title = '';



		/**

		* @var subject

		* @access protected

		*/

		protected $subject = '';



		/**

		* @var author

		* @access protected

		*/

		protected $author = '';



		/**

		* @var keywords

		* @access protected

		*/

		protected $keywords = '';



		/**

		* @var creator

		* @access protected

		*/

		protected $creator = '';



		/**

		* @var alias for total number of pages

		* @access protected

		*/

		protected $AliasNbPages = '{nb}';

		

		/**

		* @var alias for page number

		* @access protected

		*/

		protected $AliasNumPage = '{pnb}';

		

		/**

		* @var right-bottom corner X coordinate of inserted image

		* @since 2002-07-31

		* @author Nicola Asuni

		* @access protected

		*/

		protected $img_rb_x;



		/**

		* @var right-bottom corner Y coordinate of inserted image

		* @since 2002-07-31

		* @author Nicola Asuni

		* @access protected

		*/

		protected $img_rb_y;



		/**

		* @var adjusting factor to convert pixels to user units.

		* @since 2004-06-14

		* @author Nicola Asuni

		* @access protected

		*/

		protected $imgscale = 1;



		/**

		* @var boolean set to true when the input text is unicode (require unicode fonts)

		* @since 2005-01-02

		* @author Nicola Asuni

		* @access protected

		*/

		protected $isunicode = false;



		/**

		* @var PDF version

		* @since 1.5.3

		* @access protected

		*/

		protected $PDFVersion = '1.7';

		

		

		// ----------------------

		

		/**

		 * @var Minimum distance between header and top page margin.

		 * @access protected

		 */

		protected $header_margin;

		

		/**

		 * @var Minimum distance between footer and bottom page margin.

		 * @access protected

		 */

		protected $footer_margin;

		

		/**

		 * @var original left margin value

		 * @access protected

		 * @since 1.53.0.TC013

		 */

		protected $original_lMargin;

		

		/**

		 * @var original right margin value

		 * @access protected

		 * @since 1.53.0.TC013

		 */

		protected $original_rMargin;

			

		/**

		 * @var Header font.

		 * @access protected

		 */

		protected $header_font;

		

		/**

		 * @var Footer font.

		 * @access protected

		 */

		protected $footer_font;

		

		/**

		 * @var Language templates.

		 * @access protected

		 */

		protected $l;

		

		/**

		 * @var Barcode to print on page footer (only if set).

		 * @access protected

		 */

		protected $barcode = false;

		

		/**

		 * @var If true prints header

		 * @access protected

		 */

		protected $print_header = true;

		

		/**

		 * @var If true prints footer.

		 * @access protected

		 */

		protected $print_footer = true;

			

		/**

		 * @var Header image logo.

		 * @access protected

		 */

		protected $header_logo = '';

		

		/**

		 * @var Header image logo width in mm.

		 * @access protected

		 */

		protected $header_logo_width = 30;

		

		/**

		 * @var String to print as title on document header.

		 * @access protected

		 */

		protected $header_title = '';

		

		/**

		 * @var String to print on document header.

		 * @access protected

		 */

		protected $header_string = '';

		

		/**

		 * @var Default number of columns for html table.

		 * @access protected

		 */

		protected $default_table_columns = 4;

		

		

		// variables for html parser

		

		/**

		 * @var HTML PARSER: array to store current link and rendering styles.

		 * @access protected

		 */

		protected $HREF = array();

		

		/**

		 * @var store a list of available fonts on filesystem.

		 * @access protected

		 */

		protected $fontlist = array();

		

		/**

		 * @var current foreground color

		 * @access protected

		 */

		protected $fgcolor;

						

		/**

		 * @var HTML PARSER: array of boolean values, true in case of ordered list (OL), false otherwise.

		 * @access protected

		 */

		protected $listordered = array();

		

		/**

		 * @var HTML PARSER: array count list items on nested lists.

		 * @access protected

		 */

		protected $listcount = array();

		

		/**

		 * @var HTML PARSER: current list nesting level.

		 * @access protected

		 */

		protected $listnum = 0;

		

		/**

		 * @var HTML PARSER: indent amount for lists.

		 * @access protected

		 */

		protected $listindent;

		

		/**

		 * @var current background color

		 * @access protected

		 */

		protected $bgcolor;

		

		/**

		 * @var Store temporary font size in points.

		 * @access protected

		 */

		protected $tempfontsize = 10;

		

		/**

		 * @var spacer for LI tags.

		 * @access protected

		 */

		protected $lispacer = '';

		

		/**

		 * @var default encoding

		 * @access protected

		 * @since 1.53.0.TC010

		 */

		protected $encoding = 'UTF-8';

		

		/**

		 * @var PHP internal encoding

		 * @access protected

		 * @since 1.53.0.TC016

		 */

		protected $internal_encoding;

		

		/**

		 * @var indicates if the document language is Right-To-Left

		 * @access protected

		 * @since 2.0.000

		 */

		protected $rtl = false;

		

		/**

		 * @var used to force RTL or LTR string inversion

		 * @access protected

		 * @since 2.0.000

		 */

		protected $tmprtl = false;

		

		// --- Variables used for document encryption:

		

		/**

		 * Indicates whether document is protected

		 * @access protected

		 * @since 2.0.000 (2008-01-02)

		 */

		protected $encrypted;

		

		/**

		 * U entry in pdf document

		 * @access protected

		 * @since 2.0.000 (2008-01-02)

		 */

		protected $Uvalue;

		

		/**

		 * O entry in pdf document

		 * @access protected

		 * @since 2.0.000 (2008-01-02)

		 */

		protected $Ovalue;

		

		/**

		 * P entry in pdf document

		 * @access protected

		 * @since 2.0.000 (2008-01-02)

		 */

		protected $Pvalue;

		

		/**

		 * encryption object id

		 * @access protected

		 * @since 2.0.000 (2008-01-02)

		 */

		protected $enc_obj_id;

		

		/**

		 * last RC4 key encrypted (cached for optimisation)

		 * @access protected

		 * @since 2.0.000 (2008-01-02)

		 */

		protected $last_rc4_key;

		

		/**

		 * last RC4 computed key

		 * @access protected

		 * @since 2.0.000 (2008-01-02)

		 */

		protected $last_rc4_key_c;

		

		/**

		 * RC4 padding

		 * @access protected

		 */

		protected $padding = "\x28\xBF\x4E\x5E\x4E\x75\x8A\x41\x64\x00\x4E\x56\xFF\xFA\x01\x08\x2E\x2E\x00\xB6\xD0\x68\x3E\x80\x2F\x0C\xA9\xFE\x64\x53\x69\x7A";

		

		/**

		 * RC4 encryption key

		 * @access protected

		 */

		protected $encryption_key;

		

		// --- bookmark ---

		

		/**

		 * Outlines for bookmark

		 * @access protected

		 * @since 2.1.002 (2008-02-12)

		 */

		protected $outlines = array();

		

		/**

		 * Outline root for bookmark

		 * @access protected

		 * @since 2.1.002 (2008-02-12)

		 */

		protected $OutlineRoot;

		

		

		// --- javascript and form ---

		

		/**

		 * javascript code

		 * @access protected

		 * @since 2.1.002 (2008-02-12)

		 */

		protected $javascript = '';

		

		/**

		 * javascript counter

		 * @access protected

		 * @since 2.1.002 (2008-02-12)

		 */

		protected $n_js;



		/**

		 * line trough state

		 * @access protected

		 * @since 2.8.000 (2008-03-19)

		 */

		protected $linethrough;



		// --- Variables used for User's Rights ---

		// See PDF reference chapter 8.7 Digital Signatures



		/**

		 * If true enables user's rights on PDF reader

		 * @access protected

		 * @since 2.9.000 (2008-03-26)

		 */

		protected $ur;



		/**

		 * Names specifying additional document-wide usage rights for the document.

		 * @access protected

		 * @since 2.9.000 (2008-03-26)

		 */

		protected $ur_document;



		/**

		 * Names specifying additional annotation-related usage rights for the document.

		 * @access protected

		 * @since 2.9.000 (2008-03-26)

		 */

		protected $ur_annots;



		/**

		 * Names specifying additional form-field-related usage rights for the document.

		 * @access protected

		 * @since 2.9.000 (2008-03-26)

		 */

		protected $ur_form;



		/**

		 * Names specifying additional signature-related usage rights for the document.

		 * @access protected

		 * @since 2.9.000 (2008-03-26)

		 */

		protected $ur_signature;



		/**

		 * Dot Per Inch Document Resolution (do not change)

		 * @access protected

		 * @since 3.0.000 (2008-03-27)

		 */

		protected $dpi = 72;

		

		/**

		 * Array of page numbers were a new page group was started

		 * @access protected

		 * @since 3.0.000 (2008-03-27)

		 */

		protected $newpagegroup = array();

		

		/**

		 * Contains the number of pages of the groups

		 * @access protected

		 * @since 3.0.000 (2008-03-27)

		 */

		protected $pagegroups;

		

		/**

		 * Contains the alias of the current page group

		 * @access protected

		 * @since 3.0.000 (2008-03-27)

		 */

		protected $currpagegroup; 

		

		/**

		 * Restrict the rendering of some elements to screen or printout.

		 * @access protected

		 * @since 3.0.000 (2008-03-27)

		 */

		protected $visibility = 'all';

		

		/**

		 * Print visibility.

		 * @access protected

		 * @since 3.0.000 (2008-03-27)

		 */

		protected $n_ocg_print;

		

		/**

		 * View visibility.

		 * @access protected

		 * @since 3.0.000 (2008-03-27)

		 */

		protected $n_ocg_view;

		

		/**

		 * Array of transparency objects and parameters.

		 * @access protected

		 * @since 3.0.000 (2008-03-27)

		 */

		protected $extgstates;

		

		/**

		 * Set the default JPEG compression quality (1-100)

		 * @access protected

		 * @since 3.0.000 (2008-03-27)

		 */

		protected $jpeg_quality;

		

		/**

		 * Default cell height ratio.

		 * @access protected

		 * @since 3.0.014 (2008-05-23)

		 */

		protected $cell_height_ratio = K_CELL_HEIGHT_RATIO;

		

		/**

		 * PDF viewer preferences.

		 * @access protected

		 * @since 3.1.000 (2008-06-09)

		 */

		protected $viewer_preferences;

		

		/**

		 * A name object specifying how the document should be displayed when opened.

		 * @access protected

		 * @since 3.1.000 (2008-06-09)

		 */

		protected $PageMode;

		

		/**

		 * Array for storing gradient information.

		 * @access protected

		 * @since 3.1.000 (2008-06-09)

		 */

		protected $gradients = array();

		

		/**

		 * Array used to store positions inside the pages buffer.

		 * keys are the page numbers

		 * @access protected

		 * @since 3.2.000 (2008-06-26)

		 */

		protected $intmrk = array();

		

		/**

		 * Array used to store footer positions of each page.

		 * @access protected

		 * @since 3.2.000 (2008-07-01)

		 */

		protected $footerpos = array();

		

		

		/**

		 * Array used to store footer lenght of each page.

		 * @access protected

		 * @since 4.0.014 (2008-07-29)

		 */

		protected $footerlen = array();

		

		/**

		 * True if a newline is created.

		 * @access protected

		 * @since 3.2.000 (2008-07-01)

		 */

		protected $newline = true;

		

		/**

		 * End position of the latest inserted line

		 * @access protected

		 * @since 3.2.000 (2008-07-01)

		 */

		protected $endlinex = 0;

		

		/**

		 * PDF string for last line width

		 * @access protected

		 * @since 4.0.006 (2008-07-16)

		 */

		protected $linestyleWidth = '';

		

		/**

		 * PDF string for last line width

		 * @access protected

		 * @since 4.0.006 (2008-07-16)

		 */

		protected $linestyleCap = '0 J';

		

		/**

		 * PDF string for last line width

		 * @access protected

		 * @since 4.0.006 (2008-07-16)

		 */

		protected $linestyleJoin = '0 j';

		

		/**

		 * PDF string for last line width

		 * @access protected

		 * @since 4.0.006 (2008-07-16)

		 */

		protected $linestyleDash = '[] 0 d';

		

		/**

		 * True if marked-content sequence is open

		 * @access protected

		 * @since 4.0.013 (2008-07-28)

		 */

		protected $openMarkedContent = false;

		

		/**

		 * Count the latest inserted vertical spaces on HTML

		 * @access protected

		 * @since 4.0.021 (2008-08-24)

		 */

		protected $htmlvspace = 0;

		

		/**

		 * Array of Spot colors

		 * @access protected

		 * @since 4.0.024 (2008-09-12)

		 */

		protected $spot_colors = array();

		

		/**

		 * Symbol used for HTML unordered list items

		 * @access protected

		 * @since 4.0.028 (2008-09-26)

		 */

		protected $lisymbol = '';

		

		/**

		 * String used to mark the beginning and end of EPS image blocks

		 * @access protected

		 * @since 4.1.000 (2008-10-18)

		 */

		protected $epsmarker = 'x#!#EPS#!#x';

		

		/**

		 * Array of transformation matrix

		 * @access protected

		 * @since 4.2.000 (2008-10-29)

		 */

		protected $transfmatrix = array();

		

		/**

		 * Booklet mode for double-sided pages

		 * @access protected

		 * @since 4.2.000 (2008-10-29)

		 */

		protected $booklet = false;

		

		/**

		 * Epsilon value used for float calculations

		 * @access protected

		 * @since 4.2.000 (2008-10-29)

		 */

		protected $feps = 0.001;

		

		/**

		 * Array used for custom vertical spaces for HTML tags

		 * @access protected

		 * @since 4.2.001 (2008-10-30)

		 */

		protected $tagvspaces = array();

		

		/**

		 * @var HTML PARSER: custom indent amount for lists.

		 * Negative value means disabled.

		 * @access protected

		 * @since 4.2.007 (2008-11-12)

		 */

		protected $customlistindent = -1;

		

		/**

		 * @var if true keeps the border open for the cell sides that cross the page.

		 * @access protected

		 * @since 4.2.010 (2008-11-14)

		 */

		protected $opencell = true;



		/**

		 * @var array of files to embedd

		 * @access protected

		 * @since 4.4.000 (2008-12-07)

		 */

		protected $embeddedfiles = array();



		/**

		 * @var boolean true when inside html pre tag

		 * @access protected

		 * @since 4.4.001 (2008-12-08)

		 */

		protected $premode = false;



		/**

		 * Array used to store positions of graphics transformation blocks inside the page buffer.

		 * keys are the page numbers

		 * @access protected

		 * @since 4.4.002 (2008-12-09)

		 */

		protected $transfmrk = array();



		/**

		 * Default color for html links

		 * @access protected

		 * @since 4.4.003 (2008-12-09)

		 */

		protected $htmlLinkColorArray = array(0, 0, 255);



		/**

		 * Default font style to add to html links

		 * @access protected

		 * @since 4.4.003 (2008-12-09)

		 */

		protected $htmlLinkFontStyle = 'U';



		/**

		 * Counts the number of pages.

		 * @access protected

		 * @since 4.5.000 (2008-12-31)

		 */

		protected $numpages = 0;



		/**

		 * Array containing page lenghts in bytes.

		 * @access protected

		 * @since 4.5.000 (2008-12-31)

		 */

		protected $pagelen = array();



		/**

		 * Counts the number of pages.

		 * @access protected

		 * @since 4.5.000 (2008-12-31)

		 */

		protected $numimages = 0;



		/**

		 * Store the image keys.

		 * @access protected

		 * @since 4.5.000 (2008-12-31)

		 */

		protected $imagekeys = array();



		/**

		 * Lenght of the buffer in bytes.

		 * @access protected

		 * @since 4.5.000 (2008-12-31)

		 */

		protected $bufferlen = 0;



		/**

		 * If true enables disk caching.

		 * @access protected

		 * @since 4.5.000 (2008-12-31)

		 */

		protected $diskcache = false;



		/**

		 * Counts the number of fonts.

		 * @access protected

		 * @since 4.5.000 (2009-01-02)

		 */

		protected $numfonts = 0;



		/**

		 * Store the font keys.

		 * @access protected

		 * @since 4.5.000 (2009-01-02)

		 */

		protected $fontkeys = array();



		/**

		 * Store the fage status (true when opened, false when closed).

		 * @access protected

		 * @since 4.5.000 (2009-01-02)

		 */

		protected $pageopen = array();

		

		/**

		 * Default monospaced font

		 * @access protected

		 * @since 4.5.025 (2009-03-10)

		 */

		protected $default_monospaced_font = 'courier';



		/**

		 * Used to store a cloned copy of the current class object

		 * @access protected

		 * @since 4.5.029 (2009-03-19)

		 */

		protected $objcopy;



		/**

		 * Array used to store the lenghts of cache files

		 * @access protected

		 * @since 4.5.029 (2009-03-19)

		 */

		protected $cache_file_lenght = array();



		/**

		 * Table header content to be repeated on each new page

		 * @access protected

		 * @since 4.5.030 (2009-03-20)

		 */

		protected $thead = '';



		/**

		 * Distance between the top of page and end of table headers on a new page.

		 * @access protected

		 * @since 4.5.030 (2009-03-20)

		 */

		protected $theadMargin = '';



		/**

		 * Cache array for UTF8StringToArray() method.

		 * @access protected

		 * @since 4.5.037 (2009-04-07)

		 */

		protected $cache_UTF8StringToArray = array();



		/**

		 * Maximum size of cache array used for UTF8StringToArray() method.

		 * @access protected

		 * @since 4.5.037 (2009-04-07)

		 */

		protected $cache_maxsize_UTF8StringToArray = 8;



		/**

		 * Current size of cache array used for UTF8StringToArray() method.

		 * @access protected

		 * @since 4.5.037 (2009-04-07)

		 */

		protected $cache_size_UTF8StringToArray = 0;



		/**

		 * If true enables document signing

		 * @access protected

		 * @since 4.6.005 (2009-04-24)

		 */

		protected $sign = false;



		/**

		 * Signature data

		 * @access protected

		 * @since 4.6.005 (2009-04-24)

		 */

		protected $signature_data = array();



		/**

		 * Signature max lenght

		 * @access protected

		 * @since 4.6.005 (2009-04-24)

		 */

		protected $signature_max_lenght = 5120;



		/**

		 * Regular expression used to find blank characters used for word-wrapping.

		 * @access protected

		 * @since 4.6.006 (2009-04-28)

		 */

		protected $re_spaces = '/[\s\p{Z}\p{Lo}]/';



		//------------------------------------------------------------

		// METHODS

		//------------------------------------------------------------



		/**

		 * This is the class constructor. 

		 * It allows to set up the page format, the orientation and 

		 * the measure unit used in all the methods (except for the font sizes).

		 * @since 1.0

		 * @param string $orientation page orientation. Possible values are (case insensitive):<ul><li>P or Portrait (default)</li><li>L or Landscape</li></ul>

		 * @param string $unit User measure unit. Possible values are:<ul><li>pt: point</li><li>mm: millimeter (default)</li><li>cm: centimeter</li><li>in: inch</li></ul><br />A point equals 1/72 of inch, that is to say about 0.35 mm (an inch being 2.54 cm). This is a very common unit in typography; font sizes are expressed in that unit.

		 * @param mixed $format The format used for pages. It can be either one of the following values (case insensitive) or a custom format in the form of a two-element array containing the width and the height (expressed in the unit given by unit).<ul><li>4A0</li><li>2A0</li><li>A0</li><li>A1</li><li>A2</li><li>A3</li><li>A4 (default)</li><li>A5</li><li>A6</li><li>A7</li><li>A8</li><li>A9</li><li>A10</li><li>B0</li><li>B1</li><li>B2</li><li>B3</li><li>B4</li><li>B5</li><li>B6</li><li>B7</li><li>B8</li><li>B9</li><li>B10</li><li>C0</li><li>C1</li><li>C2</li><li>C3</li><li>C4</li><li>C5</li><li>C6</li><li>C7</li><li>C8</li><li>C9</li><li>C10</li><li>RA0</li><li>RA1</li><li>RA2</li><li>RA3</li><li>RA4</li><li>SRA0</li><li>SRA1</li><li>SRA2</li><li>SRA3</li><li>SRA4</li><li>LETTER</li><li>LEGAL</li><li>EXECUTIVE</li><li>FOLIO</li></ul>

		 * @param boolean $unicode TRUE means that the input text is unicode (default = true)

		 * @param boolean $diskcache if TRUE reduce the RAM memory usage by caching temporary data on filesystem (slower).

		 * @param String $encoding charset encoding; default is UTF-8

		 * @access public

		 */

		public function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false) {

			/* Set internal character encoding to ASCII */

			if (function_exists('mb_internal_encoding') AND mb_internal_encoding()) {

				$this->internal_encoding = mb_internal_encoding();

				mb_internal_encoding('ASCII');

			}

			// set disk caching

			$this->diskcache = $diskcache ? true : false;

			// set language direction

			$this->rtl = $this->l['a_meta_dir']=='rtl' ? true : false;

			$this->tmprtl = false;

			//Some checks

			$this->_dochecks();

			//Initialization of properties

			$this->isunicode = $unicode;

			$this->page = 0;

			$this->transfmrk[0] = array();

			$this->pagedim = array();

			$this->n = 2;

			$this->buffer = '';

			$this->pages = array();

			$this->state = 0;

			$this->fonts = array();

			$this->FontFiles = array();

			$this->diffs = array();

			$this->images = array();

			$this->links = array();

			$this->gradients = array();

			$this->InFooter = false;

			$this->lasth = 0;

			$this->FontFamily = 'helvetica';

			$this->FontStyle = '';

			$this->FontSizePt = 12;

			$this->underline = false;

			$this->linethrough = false;

			$this->DrawColor = '0 G';

			$this->FillColor = '0 g';

			$this->TextColor = '0 g';

			$this->ColorFlag = false;

			// encryption values

			$this->encrypted = false;

			$this->last_rc4_key = '';

			$this->padding = "\x28\xBF\x4E\x5E\x4E\x75\x8A\x41\x64\x00\x4E\x56\xFF\xFA\x01\x08\x2E\x2E\x00\xB6\xD0\x68\x3E\x80\x2F\x0C\xA9\xFE\x64\x53\x69\x7A";

			//Standard Unicode fonts

			$this->CoreFonts = array(

				'courier'=>'Courier',

				'courierB'=>'Courier-Bold',

				'courierI'=>'Courier-Oblique',

				'courierBI'=>'Courier-BoldOblique',

				'helvetica'=>'Helvetica',

				'helveticaB'=>'Helvetica-Bold',

				'helveticaI'=>'Helvetica-Oblique',

				'helveticaBI'=>'Helvetica-BoldOblique',

				'times'=>'Times-Roman',

				'timesB'=>'Times-Bold',

				'timesI'=>'Times-Italic',

				'timesBI'=>'Times-BoldItalic',

				'symbol'=>'Symbol',

				'zapfdingbats'=>'ZapfDingbats'

			);

			//Set scale factor

			$this->setPageUnit($unit);

			// set page format and orientation

			$this->setPageFormat($format, $orientation);

			//Page margins (1 cm)

			$margin = 28.35 / $this->k;

			$this->SetMargins($margin, $margin);

			//Interior cell margin

			$this->cMargin = $margin / 10;

			//Line width (0.2 mm)

			$this->LineWidth = 0.57 / $this->k;

			$this->linestyleWidth = sprintf('%.2F w', ($this->LineWidth * $this->k));

			$this->linestyleCap = '0 J';

			$this->linestyleJoin = '0 j';

			$this->linestyleDash = '[] 0 d';

			//Automatic page break

			$this->SetAutoPageBreak(true, (2 * $margin));

			//Full width display mode

			$this->SetDisplayMode('fullwidth');

			//Compression

			$this->SetCompression(true);

			//Set default PDF version number

			$this->PDFVersion = '1.7';

			$this->encoding = $encoding;

			$this->HREF = array();

			$this->getFontsList();

			$this->fgcolor = array('R' => 0, 'G' => 0, 'B' => 0);

			$this->bgcolor = array('R' => 255, 'G' => 255, 'B' => 255);

			$this->extgstates = array();

			// user's rights

			$this->sign = false;

			$this->ur = false;

			$this->ur_document = '/FullSave';

			$this->ur_annots = '/Create/Delete/Modify/Copy/Import/Export';

			$this->ur_form = '/Add/Delete/FillIn/Import/Export/SubmitStandalone/SpawnTemplate';

			$this->ur_signature = '/Modify';			

			// set default JPEG quality

			$this->jpeg_quality = 75;

			// initialize some settings

			$this->utf8Bidi(array(''), '');

			// set default font

			$this->SetFont($this->FontFamily, $this->FontStyle, $this->FontSizePt);

			// check if PCRE Unicode support is enabled

			if (@preg_match('/\pL/u', 'a') == 1) {

				// PCRE unicode support is turned ON

				// \p{Z} or \p{Separator}: any kind of Unicode whitespace or invisible separator.

				// \p{Lo} or \p{Other_Letter}: a Unicode letter or ideograph that does not have lowercase and uppercase variants.

				// \p{Lo} is needed because Chinese characters are packed next to each other without spaces in between.

				$this->re_spaces = '/[\s\p{Z}\p{Lo}]/';

			} else {

				// PCRE unicode support is turned OFF

				$this->re_spaces = '/[\s]/';

			}

		}

		

		/**

		 * Default destructor.

		 * @access public

		 * @since 1.53.0.TC016

		 */

		public function __destruct() {

			// restore internal encoding

			if (isset($this->internal_encoding) AND !empty($this->internal_encoding)) {

				mb_internal_encoding($this->internal_encoding);

			}

			// unset all class variables

			$this->_destroy(true);

		}

		

		/**

		 * Set the units of measure for the document.

		 * @param string $unit User measure unit. Possible values are:<ul><li>pt: point</li><li>mm: millimeter (default)</li><li>cm: centimeter</li><li>in: inch</li></ul><br />A point equals 1/72 of inch, that is to say about 0.35 mm (an inch being 2.54 cm). This is a very common unit in typography; font sizes are expressed in that unit.

		 * @access public

		 * @since 3.0.015 (2008-06-06)

		 */

		public function setPageUnit($unit) {

		//Set scale factor

			switch (strtolower($unit)) {

				// points

				case 'px':

				case 'pt': {

					$this->k = 1;

					break;

				}

				// millimeters

				case 'mm': {

					$this->k = $this->dpi / 25.4;

					break;

				}

				// centimeters

				case 'cm': {

					$this->k = $this->dpi / 2.54;

					break;

				}

				// inches

				case 'in': {

					$this->k = $this->dpi;

					break;

				}

				// unsupported unit

				default : {

					$this->Error('Incorrect unit: '.$unit);

					break;

				}

			}

			if (isset($this->CurOrientation)) {

					$this->setPageOrientation($this->CurOrientation);

			}

		}

		

		/**

		* Set the page format

		* @param mixed $format The format used for pages. It can be either one of the following values (case insensitive) or a custom format in the form of a two-element array containing the width and the height (expressed in the unit given by unit).<ul><li>4A0</li><li>2A0</li><li>A0</li><li>A1</li><li>A2</li><li>A3</li><li>A4 (default)</li><li>A5</li><li>A6</li><li>A7</li><li>A8</li><li>A9</li><li>A10</li><li>B0</li><li>B1</li><li>B2</li><li>B3</li><li>B4</li><li>B5</li><li>B6</li><li>B7</li><li>B8</li><li>B9</li><li>B10</li><li>C0</li><li>C1</li><li>C2</li><li>C3</li><li>C4</li><li>C5</li><li>C6</li><li>C7</li><li>C8</li><li>C9</li><li>C10</li><li>RA0</li><li>RA1</li><li>RA2</li><li>RA3</li><li>RA4</li><li>SRA0</li><li>SRA1</li><li>SRA2</li><li>SRA3</li><li>SRA4</li><li>LETTER</li><li>LEGAL</li><li>EXECUTIVE</li><li>FOLIO</li></ul>

		* @param string $orientation page orientation. Possible values are (case insensitive):<ul><li>P or PORTRAIT (default)</li><li>L or LANDSCAPE</li></ul>

		* @access public

		* @since 3.0.015 (2008-06-06)

		*/

		public function setPageFormat($format, $orientation='P') {

			//Page format

			if (is_string($format)) {

				// Page formats (45 standard ISO paper formats and 4 american common formats).

				// Paper cordinates are calculated in this way: (inches * 72) where (1 inch = 2.54 cm)

				switch (strtoupper($format)) {

					case '4A0': {$format = array(4767.87,6740.79); break;}

					case '2A0': {$format = array(3370.39,4767.87); break;}

					case 'A0': {$format = array(2383.94,3370.39); break;}

					case 'A1': {$format = array(1683.78,2383.94); break;}

					case 'A2': {$format = array(1190.55,1683.78); break;}

					case 'A3': {$format = array(841.89,1190.55); break;}

					case 'A4': default: {$format = array(595.28,841.89); break;}

					case 'A5': {$format = array(419.53,595.28); break;}

					case 'A6': {$format = array(297.64,419.53); break;}

					case 'A7': {$format = array(209.76,297.64); break;}

					case 'A8': {$format = array(147.40,209.76); break;}

					case 'A9': {$format = array(104.88,147.40); break;}

					case 'A10': {$format = array(73.70,104.88); break;}

					case 'B0': {$format = array(2834.65,4008.19); break;}

					case 'B1': {$format = array(2004.09,2834.65); break;}

					case 'B2': {$format = array(1417.32,2004.09); break;}

					case 'B3': {$format = array(1000.63,1417.32); break;}

					case 'B4': {$format = array(708.66,1000.63); break;}

					case 'B5': {$format = array(498.90,708.66); break;}

					case 'B6': {$format = array(354.33,498.90); break;}

					case 'B7': {$format = array(249.45,354.33); break;}

					case 'B8': {$format = array(175.75,249.45); break;}

					case 'B9': {$format = array(124.72,175.75); break;}

					case 'B10': {$format = array(87.87,124.72); break;}

					case 'C0': {$format = array(2599.37,3676.54); break;}

					case 'C1': {$format = array(1836.85,2599.37); break;}

					case 'C2': {$format = array(1298.27,1836.85); break;}

					case 'C3': {$format = array(918.43,1298.27); break;}

					case 'C4': {$format = array(649.13,918.43); break;}

					case 'C5': {$format = array(459.21,649.13); break;}

					case 'C6': {$format = array(323.15,459.21); break;}

					case 'C7': {$format = array(229.61,323.15); break;}

					case 'C8': {$format = array(161.57,229.61); break;}

					case 'C9': {$format = array(113.39,161.57); break;}

					case 'C10': {$format = array(79.37,113.39); break;}

					case 'RA0': {$format = array(2437.80,3458.27); break;}

					case 'RA1': {$format = array(1729.13,2437.80); break;}

					case 'RA2': {$format = array(1218.90,1729.13); break;}

					case 'RA3': {$format = array(864.57,1218.90); break;}

					case 'RA4': {$format = array(609.45,864.57); break;}

					case 'SRA0': {$format = array(2551.18,3628.35); break;}

					case 'SRA1': {$format = array(1814.17,2551.18); break;}

					case 'SRA2': {$format = array(1275.59,1814.17); break;}

					case 'SRA3': {$format = array(907.09,1275.59); break;}

					case 'SRA4': {$format = array(637.80,907.09); break;}

					case 'LETTER': {$format = array(612.00,792.00); break;}

					case 'LEGAL': {$format = array(612.00,1008.00); break;}

					case 'EXECUTIVE': {$format = array(521.86,756.00); break;}

					case 'FOLIO': {$format = array(612.00,936.00); break;}

				}

				$this->fwPt = $format[0];

				$this->fhPt = $format[1];

			} else {

				$this->fwPt = $format[0] * $this->k;

				$this->fhPt = $format[1] * $this->k;

			}

			$this->setPageOrientation($orientation);

		}

		

		/**

		* Set page orientation.

		* @param string $orientation page orientation. Possible values are (case insensitive):<ul><li>P or PORTRAIT (default)</li><li>L or LANDSCAPE</li></ul>

		* @param boolean $autopagebreak Boolean indicating if auto-page-break mode should be on or off.

		* @param float $bottommargin bottom margin of the page.

		* @access public

		* @since 3.0.015 (2008-06-06)

		*/

		public function setPageOrientation($orientation, $autopagebreak='', $bottommargin='') {

			$orientation = strtoupper($orientation);

			if (($orientation == 'P') OR ($orientation == 'PORTRAIT')) {

				$this->CurOrientation = 'P';

				$this->wPt = $this->fwPt;

				$this->hPt = $this->fhPt;

			} elseif (($orientation == 'L') OR ($orientation == 'LANDSCAPE')) {

				$this->CurOrientation = 'L';

				$this->wPt = $this->fhPt;

				$this->hPt = $this->fwPt;

			} else {

				$this->Error('Incorrect orientation: '.$orientation);

			}

			$this->w = $this->wPt / $this->k;

			$this->h = $this->hPt / $this->k;

			if ($this->empty_string($autopagebreak)) {

				if (isset($this->AutoPageBreak)) {

					$autopagebreak = $this->AutoPageBreak;

				} else {

					$autopagebreak = true;

				}

			}

			if ($this->empty_string($bottommargin)) {

				if (isset($this->bMargin)) {

					$bottommargin = $this->bMargin;

				} else {

					// default value = 2 cm

					$bottommargin = 2 * 28.35 / $this->k;

				}

			}

			$this->SetAutoPageBreak($autopagebreak, $bottommargin);

			// store page dimensions

			$this->pagedim[$this->page] = array('w' => $this->wPt, 'h' => $this->hPt, 'wk' => $this->w, 'hk' => $this->h, 'tm' => $this->tMargin, 'bm' => $bottommargin, 'lm' => $this->lMargin, 'rm' => $this->rMargin, 'pb' => $autopagebreak, 'or' => $this->CurOrientation, 'olm' => $this->original_lMargin, 'orm' => $this->original_rMargin);

		}

				

		/**

		 * Enable or disable Right-To-Left language mode

		 * @param Boolean $enable if true enable Right-To-Left language mode.

		 * @access public

		* @since 2.0.000 (2008-01-03)

		 */

		public function setRTL($enable) {

			$this->rtl = $enable ? true : false;

			$this->tmprtl = false;

		}

		

		/**

		 * Return the RTL status

		 * @return boolean

		 * @access public

		 * @since 4.0.012 (2008-07-24)

		 */

		public function getRTL() {

			return $this->rtl;

		}

		

		/**

		* Force temporary RTL language direction

		* @param mixed $mode can be false, 'L' for LTR or 'R' for RTL

		* @access public

		* @since 2.1.000 (2008-01-09)

		*/

		public function setTempRTL($mode) {

			switch ($mode) {

				case false:

				case 'L':

				case 'R': {

					$this->tmprtl = $mode;

				}

			}

		}

		

		/**

		* Set the last cell height.

		* @param float $h cell height.

		* @author Nicola Asuni

		* @access public

		* @since 1.53.0.TC034

		*/

		public function setLastH($h) {

			$this->lasth = $h;

		}

		

		/**

		* Get the last cell height.

		* @return last cell height

		* @access public

		* @since 4.0.017 (2008-08-05)

		*/

		public function getLastH() {

			return $this->lasth;

		}

		

		/**

		* Set the adjusting factor to convert pixels to user units.

		* @param float $scale adjusting factor to convert pixels to user units.

		* @author Nicola Asuni

		* @access public

		* @since 1.5.2

		*/

		public function setImageScale($scale) {

			$this->imgscale = $scale;

		}



		/**

		* Returns the adjusting factor to convert pixels to user units.

		* @return float adjusting factor to convert pixels to user units.

		* @author Nicola Asuni

		* @access public

		* @since 1.5.2

		*/

		public function getImageScale() {

			return $this->imgscale;

		}

				

		/**

		* Returns an array of page dimensions:

		* <ul><li>$this->pagedim[$this->page]['w'] => page_width_in_points</li><li>$this->pagedim[$this->page]['h'] => height in points</li><li>$this->pagedim[$this->page]['wk'] => page_width_in_points</li><li>$this->pagedim[$this->page]['hk'] => height</li><li>$this->pagedim[$this->page]['tm'] => top_margin</li><li>$this->pagedim[$this->page]['bm'] => bottom_margin</li><li>$this->pagedim[$this->page]['lm'] => left_margin</li><li>$this->pagedim[$this->page]['rm'] => right_margin</li><li>$this->pagedim[$this->page]['pb'] => auto_page_break</li><li>$this->pagedim[$this->page]['or'] => page_orientation</li><li>$this->pagedim[$this->page]['olm'] => original_left_margin</li><li>$this->pagedim[$this->page]['orm'] => original_right_margin</li></ul>

		* @param int $pagenum page number (empty = current page)

		* @return array of page dimensions.

		* @author Nicola Asuni

		* @access public

		* @since 4.5.027 (2009-03-16)

		*/

		public function getPageDimensions($pagenum='') {

			if (empty($pagenum)) {

				$pagenum = $this->page;

			}

			return $this->pagedim[$pagenum];

		}

		

		/**

		* Returns the page width in units.

		* @param int $pagenum page number (empty = current page)

		* @return int page width.

		* @author Nicola Asuni

		* @access public

		* @since 1.5.2

		* @see getPageDimensions()

		*/

		public function getPageWidth($pagenum='') {

			if (empty($pagenum)) {

				return $this->w;

			}

			return $this->pagedim[$pagenum]['w'];

		}



		/**

		* Returns the page height in units.

		* @param int $pagenum page number (empty = current page)

		* @return int page height.

		* @author Nicola Asuni

		* @access public

		* @since 1.5.2

		* @see getPageDimensions()

		*/

		public function getPageHeight($pagenum='') {

			if (empty($pagenum)) {

				return $this->h;

			}

			return $this->pagedim[$pagenum]['h'];

		}



		/**

		* Returns the page break margin.

		* @param int $pagenum page number (empty = current page)

		* @return int page break margin.

		* @author Nicola Asuni

		* @access public

		* @since 1.5.2

		* @see getPageDimensions()

		*/

		public function getBreakMargin($pagenum='') {

			if (empty($pagenum)) {

				return $this->bMargin;

			}

			return $this->pagedim[$pagenum]['bm'];

		}



		/**

		* Returns the scale factor (number of points in user unit).

		* @return int scale factor.

		* @author Nicola Asuni

		* @access public

		* @since 1.5.2

		*/

		public function getScaleFactor() {

			return $this->k;

		}



		/**

		* Defines the left, top and right margins. By default, they equal 1 cm. Call this method to change them.

		* @param float $left Left margin.

		* @param float $top Top margin.

		* @param float $right Right margin. Default value is the left one.

		* @access public

		* @since 1.0

		* @see SetLeftMargin(), SetTopMargin(), SetRightMargin(), SetAutoPageBreak()

		*/

		public function SetMargins($left, $top, $right=-1) {

			//Set left, top and right margins

			$this->lMargin = $left;

			$this->tMargin = $top;

			if ($right == -1) {

				$right = $left;

			}

			$this->rMargin = $right;

		}



		/**

		* Defines the left margin. The method can be called before creating the first page. If the current abscissa gets out of page, it is brought back to the margin.

		* @param float $margin The margin.

		* @access public

		* @since 1.4

		* @see SetTopMargin(), SetRightMargin(), SetAutoPageBreak(), SetMargins()

		*/

		public function SetLeftMargin($margin) {

			//Set left margin

			$this->lMargin=$margin;

			if (($this->page > 0) AND ($this->x < $margin)) {

				$this->x = $margin;

			}

		}



		/**

		* Defines the top margin. The method can be called before creating the first page.

		* @param float $margin The margin.

		* @access public

		* @since 1.5

		* @see SetLeftMargin(), SetRightMargin(), SetAutoPageBreak(), SetMargins()

		*/

		public function SetTopMargin($margin) {

			//Set top margin

			$this->tMargin=$margin;

			if (($this->page > 0) AND ($this->y < $margin)) {

				$this->y = $margin;

			}

		}



		/**

		* Defines the right margin. The method can be called before creating the first page.

		* @param float $margin The margin.

		* @access public

		* @since 1.5

		* @see SetLeftMargin(), SetTopMargin(), SetAutoPageBreak(), SetMargins()

		*/

		public function SetRightMargin($margin) {

			$this->rMargin=$margin;

			if (($this->page > 0) AND ($this->x > ($this->w - $margin))) {

				$this->x = $this->w - $margin;

			}

		}



		/**

		* Set the internal Cell padding.

		* @param float $pad internal padding.

		* @access public

		* @since 2.1.000 (2008-01-09)

		* @see Cell(), SetLeftMargin(), SetTopMargin(), SetAutoPageBreak(), SetMargins()

		*/

		public function SetCellPadding($pad) {

			$this->cMargin = $pad;

		}



		/**

		* Enables or disables the automatic page breaking mode. When enabling, the second parameter is the distance from the bottom of the page that defines the triggering limit. By default, the mode is on and the margin is 2 cm.

		* @param boolean $auto Boolean indicating if mode should be on or off.

		* @param float $margin Distance from the bottom of the page.

		* @access public

		* @since 1.0

		* @see Cell(), MultiCell(), AcceptPageBreak()

		*/

		public function SetAutoPageBreak($auto, $margin=0) {

			//Set auto page break mode and triggering margin

			$this->AutoPageBreak = $auto;

			$this->bMargin = $margin;

			$this->PageBreakTrigger = $this->h - $margin;

		}



		/**

		* Defines the way the document is to be displayed by the viewer.

		* @param mixed $zoom The zoom to use. It can be one of the following string values or a number indicating the zooming factor to use. <ul><li>fullpage: displays the entire page on screen </li><li>fullwidth: uses maximum width of window</li><li>real: uses real size (equivalent to 100% zoom)</li><li>default: uses viewer default mode</li></ul>

		* @param string $layout The page layout. Possible values are:<ul><li>SinglePage Display one page at a time</li><li>OneColumn Display the pages in one column</li><li>TwoColumnLeft Display the pages in two columns, with odd-numbered pages on the left</li><li>TwoColumnRight Display the pages in two columns, with odd-numbered pages on the right</li><li>TwoPageLeft (PDF 1.5) Display the pages two at a time, with odd-numbered pages on the left</li><li>TwoPageRight (PDF 1.5) Display the pages two at a time, with odd-numbered pages on the right</li></ul>

		* @param string $mode A name object specifying how the document should be displayed when opened:<ul><li>UseNone Neither document outline nor thumbnail images visible</li><li>UseOutlines Document outline visible</li><li>UseThumbs Thumbnail images visible</li><li>FullScreen Full-screen mode, with no menu bar, window controls, or any other window visible</li><li>UseOC (PDF 1.5) Optional content group panel visible</li><li>UseAttachments (PDF 1.6) Attachments panel visible</li></ul>

		* @access public

		* @since 1.2

		*/

		public function SetDisplayMode($zoom, $layout='SinglePage', $mode='UseNone') {

			//Set display mode in viewer

			if (($zoom == 'fullpage') OR ($zoom == 'fullwidth') OR ($zoom == 'real') OR ($zoom == 'default') OR (!is_string($zoom))) {

				$this->ZoomMode = $zoom;

			} else {

				$this->Error('Incorrect zoom display mode: '.$zoom);

			}

			switch ($layout) {

				case 'default':

				case 'single':

				case 'SinglePage': {

					$this->LayoutMode = 'SinglePage';

					break;

				}

				case 'continuous':

				case 'OneColumn': {

					$this->LayoutMode = 'OneColumn';

					break;

				}

				case 'two':

				case 'TwoColumnLeft': {

					$this->LayoutMode = 'TwoColumnLeft';

					break;

				}

				case 'TwoColumnRight': {

					$this->LayoutMode = 'TwoColumnRight';

					break;

				}

				case 'TwoPageLeft': {

					$this->LayoutMode = 'TwoPageLeft';

					break;

				}

				case 'TwoPageRight': {

					$this->LayoutMode = 'TwoPageRight';

					break;

				}

				default: {

					$this->LayoutMode = 'SinglePage';

				}

			}

			switch ($mode) {

				case 'UseNone': {

					$this->PageMode = 'UseNone';

					break;

				}

				case 'UseOutlines': {

					$this->PageMode = 'UseOutlines';

					break;

				}

				case 'UseThumbs': {

					$this->PageMode = 'UseThumbs';

					break;

				}

				case 'FullScreen': {

					$this->PageMode = 'FullScreen';

					break;

				}

				case 'UseOC': {

					$this->PageMode = 'UseOC';

					break;

				}

				case '': {

					$this->PageMode = 'UseAttachments';

					break;

				}

				default: {

					$this->PageMode = 'UseNone';

				}

			}

		}



		/**

		* Activates or deactivates page compression. When activated, the internal representation of each page is compressed, which leads to a compression ratio of about 2 for the resulting document. Compression is on by default.

		* Note: the Zlib extension is required for this feature. If not present, compression will be turned off.

		* @param boolean $compress Boolean indicating if compression must be enabled.

		* @access public

		* @since 1.4

		*/

		public function SetCompression($compress) {

			//Set page compression

			if (function_exists('gzcompress')) {

				$this->compress = $compress;

			} else {

				$this->compress = false;

			}

		}



		/**

		* Defines the title of the document.

		* @param string $title The title.

		* @access public

		* @since 1.2

		* @see SetAuthor(), SetCreator(), SetKeywords(), SetSubject()

		*/

		public function SetTitle($title) {

			//Title of document

			$this->title = $title;

		}



		/**

		* Defines the subject of the document.

		* @param string $subject The subject.

		* @access public

		* @since 1.2

		* @see SetAuthor(), SetCreator(), SetKeywords(), SetTitle()

		*/

		public function SetSubject($subject) {

			//Subject of document

			$this->subject = $subject;

		}



		/**

		* Defines the author of the document.

		* @param string $author The name of the author.

		* @access public

		* @since 1.2

		* @see SetCreator(), SetKeywords(), SetSubject(), SetTitle()

		*/

		public function SetAuthor($author) {

			//Author of document

			$this->author = $author;

		}



		/**

		* Associates keywords with the document, generally in the form 'keyword1 keyword2 ...'.

		* @param string $keywords The list of keywords.

		* @access public

		* @since 1.2

		* @see SetAuthor(), SetCreator(), SetSubject(), SetTitle()

		*/

		public function SetKeywords($keywords) {

			//Keywords of document

			$this->keywords = $keywords;

		}



		/**

		* Defines the creator of the document. This is typically the name of the application that generates the PDF.

		* @param string $creator The name of the creator.

		* @access public

		* @since 1.2

		* @see SetAuthor(), SetKeywords(), SetSubject(), SetTitle()

		*/

		public function SetCreator($creator) {

			//Creator of document

			$this->creator = $creator;

		}

		

		/**

		* This method is automatically called in case of fatal error; it simply outputs the message and halts the execution. An inherited class may override it to customize the error handling but should always halt the script, or the resulting document would probably be invalid.

		* 2004-06-11 :: Nicola Asuni : changed bold tag with strong

		* @param string $msg The error message

		* @access public

		* @since 1.0

		*/

		public function Error($msg) {

			// unset all class variables

			$this->_destroy(true);

			// exit program and print error

			die('<strong>TCPDF ERROR: </strong>'.$msg);

		}



		/**

		* This method begins the generation of the PDF document.

		* It is not necessary to call it explicitly because AddPage() does it automatically.

		* Note: no page is created by this method

		* @access public

		* @since 1.0

		* @see AddPage(), Close()

		*/

		public function Open() {

			//Begin document

			$this->state = 1;

		}



		/**

		* Terminates the PDF document.

		* It is not necessary to call this method explicitly because Output() does it automatically.

		* If the document contains no page, AddPage() is called to prevent from getting an invalid document.

		* @access public

		* @since 1.0

		* @see Open(), Output()

		*/

		public function Close() {

			if ($this->state == 3) {

				return;

			}

			if ($this->page == 0) {

				$this->AddPage();

			}

			// close page

			$this->endPage();

			// close document

			$this->_enddoc();

			// unset all class variables (except critical ones)

			$this->_destroy(false);

		}

		

		/**

		* Move pointer at the specified document page and update page dimensions.

		* @param int $pnum page number

		* @param boolean $resetmargins if true reset left, right, top margins and Y position.

		* @access public

		* @since 2.1.000 (2008-01-07)

		* @see getPage(), lastpage(), getNumPages()

		*/

		public function setPage($pnum, $resetmargins=false) {

			if ($pnum == $this->page) {

				return;

			}

			if (($pnum > 0) AND ($pnum <= $this->numpages)) {

				$this->state = 2;

				// save current graphic settings

				//$gvars = $this->getGraphicVars();

				$oldpage = $this->page;

				$this->page = $pnum;

				$this->wPt = $this->pagedim[$this->page]['w'];

				$this->hPt = $this->pagedim[$this->page]['h'];

				$this->w = $this->wPt / $this->k;

				$this->h = $this->hPt / $this->k;

				$this->tMargin = $this->pagedim[$this->page]['tm'];

				$this->bMargin = $this->pagedim[$this->page]['bm'];

				$this->original_lMargin = $this->pagedim[$this->page]['olm'];

				$this->original_rMargin = $this->pagedim[$this->page]['orm'];

				$this->AutoPageBreak = $this->pagedim[$this->page]['pb'];

				$this->CurOrientation = $this->pagedim[$this->page]['or'];

				$this->SetAutoPageBreak($this->AutoPageBreak, $this->bMargin);

				// restore graphic settings

				//$this->setGraphicVars($gvars);

				if ($resetmargins) {

					$this->lMargin = $this->pagedim[$this->page]['olm'];

					$this->rMargin = $this->pagedim[$this->page]['orm'];

					$this->SetY($this->tMargin);

				} else {

					// account for booklet mode

					if ($this->pagedim[$this->page]['olm'] != $this->pagedim[$oldpage]['olm']) {

						$deltam = $this->pagedim[$this->page]['olm'] - $this->pagedim[$this->page]['orm'];

						$this->lMargin += $deltam;

						$this->rMargin -= $deltam;

					}

				}

			} else {

				$this->Error('Wrong page number on setPage() function.');

			}

		}

		

		/**

		* Reset pointer to the last document page.

		* @param boolean $resetmargins if true reset left, right, top margins and Y position.

		* @access public

		* @since 2.0.000 (2008-01-04)

		* @see setPage(), getPage(), getNumPages()

		*/

		public function lastPage($resetmargins=false) {

			$this->setPage($this->getNumPages(), $resetmargins);

		}

		

		/**

		* Get current document page number.

		* @return int page number

		* @access public

		* @since 2.1.000 (2008-01-07)

		* @see setPage(), lastpage(), getNumPages()

		*/

		public function getPage() {

			return $this->page;

		}

		

		

		/**

		* Get the total number of insered pages.

		* @return int number of pages

		* @access public

		* @since 2.1.000 (2008-01-07)

		* @see setPage(), getPage(), lastpage()

		*/

		public function getNumPages() {

			return $this->numpages;

		}



		/**

		* Adds a new page to the document. If a page is already present, the Footer() method is called first to output the footer (if enabled). Then the page is added, the current position set to the top-left corner according to the left and top margins (or top-right if in RTL mode), and Header() is called to display the header (if enabled).

		* The origin of the coordinate system is at the top-left corner (or top-right for RTL) and increasing ordinates go downwards.

		* @param string $orientation page orientation. Possible values are (case insensitive):<ul><li>P or PORTRAIT (default)</li><li>L or LANDSCAPE</li></ul>

		* @param mixed $format The format used for pages. It can be either one of the following values (case insensitive) or a custom format in the form of a two-element array containing the width and the height (expressed in the unit given by unit).<ul><li>4A0</li><li>2A0</li><li>A0</li><li>A1</li><li>A2</li><li>A3</li><li>A4 (default)</li><li>A5</li><li>A6</li><li>A7</li><li>A8</li><li>A9</li><li>A10</li><li>B0</li><li>B1</li><li>B2</li><li>B3</li><li>B4</li><li>B5</li><li>B6</li><li>B7</li><li>B8</li><li>B9</li><li>B10</li><li>C0</li><li>C1</li><li>C2</li><li>C3</li><li>C4</li><li>C5</li><li>C6</li><li>C7</li><li>C8</li><li>C9</li><li>C10</li><li>RA0</li><li>RA1</li><li>RA2</li><li>RA3</li><li>RA4</li><li>SRA0</li><li>SRA1</li><li>SRA2</li><li>SRA3</li><li>SRA4</li><li>LETTER</li><li>LEGAL</li><li>EXECUTIVE</li><li>FOLIO</li></ul>

		* @access public

		* @since 1.0

		* @see startPage(), endPage()

		*/

		public function AddPage($orientation='', $format='') {

			if (!isset($this->original_lMargin)) {

				$this->original_lMargin = $this->lMargin;

			}

			if (!isset($this->original_rMargin)) {

				$this->original_rMargin = $this->rMargin;

			}

			// terminate previous page

			$this->endPage();

			// start new page

			$this->startPage($orientation, $format);

		}



		/**

		* Terminate the current page

		* @access protected

		* @since 4.2.010 (2008-11-14)

		* @see startPage(), AddPage()

		*/

		protected function endPage() {

			// check if page is already closed

			if (($this->page == 0) OR ($this->numpages > $this->page) OR (!$this->pageopen[$this->page])) {

				return;

			}

			$this->InFooter = true;

			// print page footer

			$this->setFooter();

			// close page

			$this->_endpage();

			// mark page as closed

			$this->pageopen[$this->page] = false;

			$this->InFooter = false;

		}



		/**

		* Starts a new page to the document. The page must be closed using the endPage() function.

		* The origin of the coordinate system is at the top-left corner and increasing ordinates go downwards.

		* @param string $orientation page orientation. Possible values are (case insensitive):<ul><li>P or PORTRAIT (default)</li><li>L or LANDSCAPE</li></ul>

		* @param mixed $format The format used for pages. It can be either one of the following values (case insensitive) or a custom format in the form of a two-element array containing the width and the height (expressed in the unit given by unit).<ul><li>4A0</li><li>2A0</li><li>A0</li><li>A1</li><li>A2</li><li>A3</li><li>A4 (default)</li><li>A5</li><li>A6</li><li>A7</li><li>A8</li><li>A9</li><li>A10</li><li>B0</li><li>B1</li><li>B2</li><li>B3</li><li>B4</li><li>B5</li><li>B6</li><li>B7</li><li>B8</li><li>B9</li><li>B10</li><li>C0</li><li>C1</li><li>C2</li><li>C3</li><li>C4</li><li>C5</li><li>C6</li><li>C7</li><li>C8</li><li>C9</li><li>C10</li><li>RA0</li><li>RA1</li><li>RA2</li><li>RA3</li><li>RA4</li><li>SRA0</li><li>SRA1</li><li>SRA2</li><li>SRA3</li><li>SRA4</li><li>LETTER</li><li>LEGAL</li><li>EXECUTIVE</li><li>FOLIO</li></ul>

		* @access protected

		* @since 4.2.010 (2008-11-14)

		* @see endPage(), AddPage()

		*/

		protected function startPage($orientation='', $format='') {

			if ($this->numpages > $this->page) {

				// this page has been already added

				$this->setPage($this->page + 1);

				$this->SetY($this->tMargin);

				return;

			}

			// start a new page

			if ($this->state == 0) {

				$this->Open();

			}

			++$this->numpages;

			$this->swapMargins($this->booklet);

			// save current graphic settings

			$gvars = $this->getGraphicVars();

			// start new page

			$this->_beginpage($orientation, $format);

			// mark page as open

			$this->pageopen[$this->page] = true;

			// restore graphic settings

			$this->setGraphicVars($gvars);

			// mark this point

			$this->setPageMark();

			// print page header

			$this->setHeader();

			// restore graphic settings

			$this->setGraphicVars($gvars);

			// mark this point

			$this->setPageMark();

			// print table header (if any)

			$this->setTableHeader();

		}

			

		/**

	 	 * Set start-writing mark on current page for multicell borders and fills.

	 	 * This function must be called after calling Image() function for a background image.

	 	 * Background images must be always inserted before calling Multicell() or WriteHTMLCell() or WriteHTML() functions.

	 	 * @access public

	 	 * @since 4.0.016 (2008-07-30)

		 */

		public function setPageMark() {

			$this->intmrk[$this->page] = $this->pagelen[$this->page];

		}

		

		/**

	 	 * Set header data.

		 * @param string $ln header image logo

		 * @param string $lw header image logo width in mm

		 * @param string $ht string to print as title on document header

		 * @param string $hs string to print on document header

		 * @access public

		 */

		public function setHeaderData($ln='', $lw=0, $ht='', $hs='') {

			$this->header_logo = $ln;

			$this->header_logo_width = $lw;

			$this->header_title = $ht;

			$this->header_string = $hs;

		}

		

		/**

	 	 * Returns header data:

	 	 * <ul><li>$ret['logo'] = logo image</li><li>$ret['logo_width'] = width of the image logo in user units</li><li>$ret['title'] = header title</li><li>$ret['string'] = header description string</li></ul>

		 * @return array()

		 * @access public

		 * @since 4.0.012 (2008-07-24)

		 */

		public function getHeaderData() {

			$ret = array();

			$ret['logo'] = $this->header_logo;

			$ret['logo_width'] = $this->header_logo_width;

			$ret['title'] = $this->header_title;

			$ret['string'] = $this->header_string;

			return $ret;

		}

		

		/**

	 	 * Set header margin.

		 * (minimum distance between header and top page margin)

		 * @param int $hm distance in user units

		 * @access public

		 */

		public function setHeaderMargin($hm=10) {

			$this->header_margin = $hm;

		}

		

		/**

	 	 * Returns header margin in user units.

		 * @return float

		 * @since 4.0.012 (2008-07-24)

		 * @access public

		 */

		public function getHeaderMargin() {

			return $this->header_margin;

		}

		

		/**

	 	 * Set footer margin.

		 * (minimum distance between footer and bottom page margin)

		 * @param int $fm distance in user units

		 * @access public

		 */

		public function setFooterMargin($fm=10) {

			$this->footer_margin = $fm;

		}

		

		/**

	 	 * Returns footer margin in user units.

		 * @return float

		 * @since 4.0.012 (2008-07-24)

		 * @access public

		 */

		public function getFooterMargin() {

			return $this->footer_margin;

		}

		/**

	 	 * Set a flag to print page header.

		 * @param boolean $val set to true to print the page header (default), false otherwise. 

		 * @access public

		 */

		public function setPrintHeader($val=true) {

			$this->print_header = $val;

		}

		

		/**

	 	 * Set a flag to print page footer.

		 * @param boolean $value set to true to print the page footer (default), false otherwise. 

		 * @access public

		 */

		public function setPrintFooter($val=true) {

			$this->print_footer = $val;

		}

		

		/**

	 	 * Return the right-bottom (or left-bottom for RTL) corner X coordinate of last inserted image

		 * @return float 

		 * @access public

		 */

		public function getImageRBX() {

			return $this->img_rb_x;

		}

		

		/**

	 	 * Return the right-bottom (or left-bottom for RTL) corner Y coordinate of last inserted image

		 * @return float 

		 * @access public

		 */

		public function getImageRBY() {

			return $this->img_rb_y;

		}

		

		/**

	 	 * This method is used to render the page header.

	 	 * It is automatically called by AddPage() and could be overwritten in your own inherited class.

		 * @access public

		 */

		public function Header() {

			$ormargins = $this->getOriginalMargins();

			$headerfont = $this->getHeaderFont();

			$headerdata = $this->getHeaderData();

			if (($headerdata['logo']) AND ($headerdata['logo'] != K_BLANK_IMAGE)) {

				$this->Image(K_PATH_IMAGES.$headerdata['logo'], $this->GetX(), $this->getHeaderMargin(), $headerdata['logo_width']);

				$imgy = $this->getImageRBY();

			} else {

				$imgy = $this->GetY();

			}

			$cell_height = round(($this->getCellHeightRatio() * $headerfont[2]) / $this->getScaleFactor(), 2);

			// set starting margin for text data cell

			if ($this->getRTL()) {

				$header_x = $ormargins['right'] + ($headerdata['logo_width'] * 1.1);

			} else {

				$header_x = $ormargins['left'] + ($headerdata['logo_width'] * 1.1);

			}

			$this->SetTextColor(0, 0, 0);

			// header title

			$this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);

			$this->SetX($header_x);			

			$this->Cell(0, $cell_height, $headerdata['title'], 0, 1, '', 0, '', 0);

			// header string

			$this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);

			$this->SetX($header_x);

			$this->MultiCell(0, $cell_height, $headerdata['string'], 0, '', 0, 1, '', '', true, 0, false);

			// print an ending header line

			$this->SetLineStyle(array('width' => 0.85 / $this->getScaleFactor(), 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

			$this->SetY((2.835 / $this->getScaleFactor()) + max($imgy, $this->GetY()));

			if ($this->getRTL()) {

				$this->SetX($ormargins['right']);

			} else {

				$this->SetX($ormargins['left']);

			}

			$this->Cell(0, 0, '', 'T', 0, 'C');

		}

		

		/**

	 	 * This method is used to render the page footer. 

	 	 * It is automatically called by AddPage() and could be overwritten in your own inherited class.

		 * @access public

		 */

		public function Footer() {				

			$cur_y = $this->GetY();

			$ormargins = $this->getOriginalMargins();

			$this->SetTextColor(0, 0, 0);			

			//set style for cell border

			$line_width = 0.85 / $this->getScaleFactor();

			$this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

			//print document barcode

			$barcode = $this->getBarcode();

			if (!empty($barcode)) {

				$this->Ln($line_width);

				$barcode_width = round(($this->getPageWidth() - $ormargins['left'] - $ormargins['right'])/3);

				$this->write1DBarcode($barcode, 'C128B', $this->GetX(), $cur_y + $line_width, $barcode_width, (($this->getFooterMargin() / 3) - $line_width), 0.3, '', '');	

			}

			if (empty($this->pagegroups)) {

				$pagenumtxt = $this->l['w_page'].' '.$this->getAliasNumPage().' / '.$this->getAliasNbPages();

			} else {

				$pagenumtxt = $this->l['w_page'].' '.$this->getPageNumGroupAlias().' / '.$this->getPageGroupAlias();

			}		

			$this->SetY($cur_y);

			//Print page number

			if ($this->getRTL()) {

				$this->SetX($ormargins['right']);

//				$this->Cell(0, 0, $pagenumtxt, 'T', 0, 'L');

			} else {

				$this->SetX($ormargins['left']);

//				$this->Cell(0, 0, $pagenumtxt, 'T', 0, 'R');

			}

		}

		

		/**

	 	 * This method is used to render the page header. 

	 	 * @access protected

	 	 * @since 4.0.012 (2008-07-24)

		 */

		protected function setHeader() {

			if ($this->print_header) {

				$lasth = $this->lasth;

				$this->_out('q');

				$this->rMargin = $this->original_rMargin;

				$this->lMargin = $this->original_lMargin;

				$this->cMargin = 0;

				//set current position

				if ($this->rtl) {

					$this->SetXY($this->original_rMargin, $this->header_margin);

				} else {

					$this->SetXY($this->original_lMargin, $this->header_margin);

				}

				$this->SetFont($this->header_font[0], $this->header_font[1], $this->header_font[2]);

				$this->Header();

				//restore position

				if ($this->rtl) {

					$this->SetXY($this->original_rMargin, $this->tMargin);

				} else {

					$this->SetXY($this->original_lMargin, $this->tMargin);

				}

				$this->_out('Q');

				$this->lasth = $lasth;

			}

		}

		

		/**

	 	 * This method is used to render the page footer. 

	 	 * @access protected

	 	 * @since 4.0.012 (2008-07-24)

		 */

		protected function setFooter() {

			//Page footer

			// save current graphic settings

			$gvars = $this->getGraphicVars();

			// mark this point

			$this->footerpos[$this->page] = $this->pagelen[$this->page];

			$this->_out("\n");

			if ($this->print_footer) {

				$lasth = $this->lasth;

				$this->_out('q');

				$this->rMargin = $this->original_rMargin;

				$this->lMargin = $this->original_lMargin;

				$this->cMargin = 0;

				//set current position

				$footer_y = $this->h - $this->footer_margin;

				if ($this->rtl) {

					$this->SetXY($this->original_rMargin, $footer_y);

				} else {

					$this->SetXY($this->original_lMargin, $footer_y);

				}

				$this->SetFont($this->footer_font[0], $this->footer_font[1], $this->footer_font[2]);

				$this->Footer();

				//restore position

				if ($this->rtl) {

					$this->SetXY($this->original_rMargin, $this->tMargin);

				} else {

					$this->SetXY($this->original_lMargin, $this->tMargin);

				}

				$this->_out('Q');

				$this->lasth = $lasth;

			}

			// restore graphic settings

			$this->setGraphicVars($gvars);

			// calculate footer lenght

			$this->footerlen[$this->page] = $this->pagelen[$this->page] - $this->footerpos[$this->page] + 1;

		}



		/**

	 	 * This method is used to render the table header on new page (if any). 

	 	 * @access protected

	 	 * @since 4.5.030 (2009-03-25)

		 */

		protected function setTableHeader() {

			if (!$this->empty_string($this->theadMargin)) {

				// restore the original top-margin

				$this->tMargin = $this->theadMargin;

				$this->pagedim[$this->page]['tm'] = $this->theadMargin;

				$this->y = $this->theadMargin;

			}

			if (!$this->empty_string($this->thead)) {

				// print table header

				$this->writeHTML($this->thead, false, false, false, false, '');

				// set new top margin to skip the table headers

				if (!isset($this->theadMargin) OR ($this->empty_string($this->theadMargin))) {

					$this->theadMargin = $this->tMargin;

				}

				$this->tMargin = $this->y;

				$this->pagedim[$this->page]['tm'] = $this->tMargin;

			}

		}

		

		/**

		* Returns the current page number.

		* @return int page number

		* @access public

		* @since 1.0

		* @see AliasNbPages(), getAliasNbPages()

		*/

		public function PageNo() {

			return $this->page;

		}



		/**

		* Defines a new spot color. 

		* It can be expressed in RGB components or gray scale. 

		* The method can be called before the first page is created and the value is retained from page to page.

		* @param int $c Cyan color for CMYK. Value between 0 and 255

		* @param int $m Magenta color for CMYK. Value between 0 and 255

		* @param int $y Yellow color for CMYK. Value between 0 and 255

		* @param int $k Key (Black) color for CMYK. Value between 0 and 255

		* @access public

		* @since 4.0.024 (2008-09-12)

		* @see SetDrawSpotColor(), SetFillSpotColor(), SetTextSpotColor()

		*/

		public function AddSpotColor($name, $c, $m, $y, $k) {

			if (!isset($this->spot_colors[$name])) {

				$i = 1 + count($this->spot_colors);

				$this->spot_colors[$name] = array('i' => $i, 'c' => $c, 'm' => $m, 'y' => $y, 'k' => $k);

			}

		}



		/**

		* Defines the color used for all drawing operations (lines, rectangles and cell borders). 

		* It can be expressed in RGB components or gray scale. 

		* The method can be called before the first page is created and the value is retained from page to page.

		* @param array $color array of colors

		* @access public

		* @since 3.1.000 (2008-06-11)

		* @see SetDrawColor()

		*/

		public function SetDrawColorArray($color) {

			if (isset($color)) {

				$color = array_values($color);

				$r = isset($color[0]) ? $color[0] : -1;

				$g = isset($color[1]) ? $color[1] : -1;

				$b = isset($color[2]) ? $color[2] : -1;

				$k = isset($color[3]) ? $color[3] : -1;

				if ($r >= 0) {

					$this->SetDrawColor($r, $g, $b, $k);

				}

			}

		}



		/**

		* Defines the color used for all drawing operations (lines, rectangles and cell borders). It can be expressed in RGB components or gray scale. The method can be called before the first page is created and the value is retained from page to page.

		* @param int $col1 Gray level for single color, or Red color for RGB, or Cyan color for CMYK. Value between 0 and 255

		* @param int $col2 Green color for RGB, or Magenta color for CMYK. Value between 0 and 255

		* @param int $col3 Blue color for RGB, or Yellow color for CMYK. Value between 0 and 255

		* @param int $col4 Key (Black) color for CMYK. Value between 0 and 255

		* @access public

		* @since 1.3

		* @see SetDrawColorArray(), SetFillColor(), SetTextColor(), Line(), Rect(), Cell(), MultiCell()

		*/

		public function SetDrawColor($col1=0, $col2=-1, $col3=-1, $col4=-1) {

			// set default values

			if (!is_numeric($col1)) {

				$col1 = 0;

			}

			if (!is_numeric($col2)) {

				$col2 = -1;

			}

			if (!is_numeric($col3)) {

				$col3 = -1;

			}

			if (!is_numeric($col4)) {

				$col4 = -1;

			}

			//Set color for all stroking operations

			if (($col2 == -1) AND ($col3 == -1) AND ($col4 == -1)) {

				// Grey scale

				$this->DrawColor = sprintf('%.3F G', $col1/255);

			} elseif ($col4 == -1) {

				// RGB

				$this->DrawColor = sprintf('%.3F %.3F %.3F RG', $col1/255, $col2/255, $col3/255);

			} else {

				// CMYK

				$this->DrawColor = sprintf('%.3F %.3F %.3F %.3F K', $col1/100, $col2/100, $col3/100, $col4/100);

			}

			if ($this->page > 0) {

				$this->_out($this->DrawColor);

			}

		}

		

		/**

		* Defines the spot color used for all drawing operations (lines, rectangles and cell borders).

		* @param string $name name of the spot color

		* @param int $tint the intensity of the color (from 0 to 100 ; 100 = full intensity by default).

		* @access public

		* @since 4.0.024 (2008-09-12)

		* @see AddSpotColor(), SetFillSpotColor(), SetTextSpotColor()

		*/

		public function SetDrawSpotColor($name, $tint=100) {

			if (!isset($this->spot_colors[$name])) {

				$this->Error('Undefined spot color: '.$name);

			}

			$this->DrawColor = sprintf('/CS%d CS %.3F SCN', $this->spot_colors[$name]['i'], $tint/100);

			if ($this->page > 0) {

				$this->_out($this->DrawColor);

			}

		}

		

		/**

		* Defines the color used for all filling operations (filled rectangles and cell backgrounds). 

		* It can be expressed in RGB components or gray scale. 

		* The method can be called before the first page is created and the value is retained from page to page.

		* @param array $color array of colors

		* @access public

		* @since 3.1.000 (2008-6-11)

		* @see SetFillColor()

		*/

		public function SetFillColorArray($color) {

			if (isset($color)) {

				$color = array_values($color);

				$r = isset($color[0]) ? $color[0] : -1;

				$g = isset($color[1]) ? $color[1] : -1;

				$b = isset($color[2]) ? $color[2] : -1;

				$k = isset($color[3]) ? $color[3] : -1;

				if ($r >= 0) {

					$this->SetFillColor($r, $g, $b, $k);

				}

			}

		}

		

		/**

		* Defines the color used for all filling operations (filled rectangles and cell backgrounds). It can be expressed in RGB components or gray scale. The method can be called before the first page is created and the value is retained from page to page.

		* @param int $col1 Gray level for single color, or Red color for RGB, or Cyan color for CMYK. Value between 0 and 255

		* @param int $col2 Green color for RGB, or Magenta color for CMYK. Value between 0 and 255

		* @param int $col3 Blue color for RGB, or Yellow color for CMYK. Value between 0 and 255

		* @param int $col4 Key (Black) color for CMYK. Value between 0 and 255

		* @access public

		* @since 1.3

		* @see SetFillColorArray(), SetDrawColor(), SetTextColor(), Rect(), Cell(), MultiCell()

		*/

		public function SetFillColor($col1=0, $col2=-1, $col3=-1, $col4=-1) {

			// set default values

			if (!is_numeric($col1)) {

				$col1 = 0;

			}

			if (!is_numeric($col2)) {

				$col2 = -1;

			}

			if (!is_numeric($col3)) {

				$col3 = -1;

			}

			if (!is_numeric($col4)) {

				$col4 = -1;

			}

			//Set color for all filling operations

			if (($col2 == -1) AND ($col3 == -1) AND ($col4 == -1)) {

				// Grey scale

				$this->FillColor = sprintf('%.3F g', $col1/255);

				$this->bgcolor = array('G' => $col1);

			} elseif ($col4 == -1) {

				// RGB

				$this->FillColor = sprintf('%.3F %.3F %.3F rg', $col1/255, $col2/255, $col3/255);

				$this->bgcolor = array('R' => $col1, 'G' => $col2, 'B' => $col3);

			} else {

				// CMYK

				$this->FillColor = sprintf('%.3F %.3F %.3F %.3F k', $col1/100, $col2/100, $col3/100, $col4/100);

				$this->bgcolor = array('C' => $col1, 'M' => $col2, 'Y' => $col3, 'K' => $col4);

			}

			$this->ColorFlag = ($this->FillColor != $this->TextColor);

			if ($this->page > 0) {

				$this->_out($this->FillColor);

			}

		}

		

		/**

		* Defines the spot color used for all filling operations (filled rectangles and cell backgrounds).

		* @param string $name name of the spot color

		* @param int $tint the intensity of the color (from 0 to 100 ; 100 = full intensity by default).

		* @access public

		* @since 4.0.024 (2008-09-12)

		* @see AddSpotColor(), SetDrawSpotColor(), SetTextSpotColor()

		*/

		public function SetFillSpotColor($name, $tint=100) {

			if (!isset($this->spot_colors[$name])) {

				$this->Error('Undefined spot color: '.$name);

			}

			$this->FillColor = sprintf('/CS%d cs %.3F scn', $this->spot_colors[$name]['i'], $tint/100);

			$this->ColorFlag = ($this->FillColor != $this->TextColor);

			if ($this->page > 0) {

				$this->_out($this->FillColor);

			}

		}

		

		/**

		* Defines the color used for text. It can be expressed in RGB components or gray scale. 

		* The method can be called before the first page is created and the value is retained from page to page.

		* @param array $color array of colors

		* @access public

		* @since 3.1.000 (2008-6-11)

		* @see SetFillColor()

		*/

		public function SetTextColorArray($color) {

			if (isset($color)) {

				$color = array_values($color);

				$r = isset($color[0]) ? $color[0] : -1;

				$g = isset($color[1]) ? $color[1] : -1;

				$b = isset($color[2]) ? $color[2] : -1;

				$k = isset($color[3]) ? $color[3] : -1;

				if ($r >= 0) {

					$this->SetTextColor($r, $g, $b, $k);

				}

			}

		}



		/**

		* Defines the color used for text. It can be expressed in RGB components or gray scale. The method can be called before the first page is created and the value is retained from page to page.

		* @param int $col1 Gray level for single color, or Red color for RGB, or Cyan color for CMYK. Value between 0 and 255

		* @param int $col2 Green color for RGB, or Magenta color for CMYK. Value between 0 and 255

		* @param int $col3 Blue color for RGB, or Yellow color for CMYK. Value between 0 and 255

		* @param int $col4 Key (Black) color for CMYK. Value between 0 and 255

		* @access public

		* @since 1.3

		* @see SetTextColorArray(), SetDrawColor(), SetFillColor(), Text(), Cell(), MultiCell()

		*/

		public function SetTextColor($col1=0, $col2=-1, $col3=-1, $col4=-1) {

			// set default values

			if (!is_numeric($col1)) {

				$col1 = 0;

			}

			if (!is_numeric($col2)) {

				$col2 = -1;

			}

			if (!is_numeric($col3)) {

				$col3 = -1;

			}

			if (!is_numeric($col4)) {

				$col4 = -1;

			}

			//Set color for text

			if (($col2 == -1) AND ($col3 == -1) AND ($col4 == -1)) {

				// Grey scale

				$this->TextColor = sprintf('%.3F g', $col1/255);

				$this->fgcolor = array('G' => $col1);

			} elseif ($col4 == -1) {

				// RGB

				$this->TextColor = sprintf('%.3F %.3F %.3F rg', $col1/255, $col2/255, $col3/255);

				$this->fgcolor = array('R' => $col1, 'G' => $col2, 'B' => $col3);

			} else {

				// CMYK

				$this->TextColor = sprintf('%.3F %.3F %.3F %.3F k', $col1/100, $col2/100, $col3/100, $col4/100);

				$this->fgcolor = array('C' => $col1, 'M' => $col2, 'Y' => $col3, 'K' => $col4);

			}

			$this->ColorFlag = ($this->FillColor != $this->TextColor);

		}

		

		/**

		* Defines the spot color used for text.

		* @param string $name name of the spot color

		* @param int $tint the intensity of the color (from 0 to 100 ; 100 = full intensity by default).

		* @access public

		* @since 4.0.024 (2008-09-12)

		* @see AddSpotColor(), SetDrawSpotColor(), SetFillSpotColor()

		*/

		public function SetTextSpotColor($name, $tint=100) {

			if (!isset($this->spot_colors[$name])) {

				$this->Error('Undefined spot color: '.$name);

			}

			$this->TextColor = sprintf('/CS%d cs %.3F scn', $this->spot_colors[$name]['i'], $tint/100);

			$this->ColorFlag = ($this->FillColor != $this->TextColor);

			if ($this->page > 0) {

				$this->_out($this->TextColor);

			}

		}



		/**

		* Returns the length of a string in user unit. A font must be selected.<br>

		* @param string $s The string whose length is to be computed

		* @param string $fontname Family font. It can be either a name defined by AddFont() or one of the standard families. It is also possible to pass an empty string, in that case, the current family is retained.

		* @param string $fontstyle Font style. Possible values are (case insensitive):<ul><li>empty string: regular</li><li>B: bold</li><li>I: italic</li><li>U: underline</li><li>D: line trough</li></ul> or any combination. The default value is regular.

		* @param float $fontsize Font size in points. The default value is the current size.

		* @return int string length

		* @author Nicola Asuni

		* @access public

		* @since 1.2

		*/

		public function GetStringWidth($s, $fontname='', $fontstyle='', $fontsize=0) {

			return $this->GetArrStringWidth($this->utf8Bidi($this->UTF8StringToArray($s), $s, $this->tmprtl), $fontname, $fontstyle, $fontsize);

		}

		

		/**

		* Returns the string length of an array of chars in user unit. A font must be selected.<br>

		* @param string $arr The array of chars whose total length is to be computed

		* @param string $fontname Family font. It can be either a name defined by AddFont() or one of the standard families. It is also possible to pass an empty string, in that case, the current family is retained.

		* @param string $fontstyle Font style. Possible values are (case insensitive):<ul><li>empty string: regular</li><li>B: bold</li><li>I: italic</li><li>U: underline</li><li>D: line trough</li></ul> or any combination. The default value is regular.

		* @param float $fontsize Font size in points. The default value is the current size.

		* @return int string length

		* @author Nicola Asuni

		* @access public

		* @since 2.4.000 (2008-03-06)

		*/

		public function GetArrStringWidth($sa, $fontname='', $fontstyle='', $fontsize=0) {

			// store current values

			if (!$this->empty_string($fontname)) {

				$prev_FontFamily = $this->FontFamily;

				$prev_FontStyle = $this->FontStyle;

				$prev_FontSizePt = $this->FontSizePt;

				$this->SetFont($fontname, $fontstyle, $fontsize);

			}

			$w = 0;

			foreach ($sa as $char) {

				$w += $this->GetCharWidth($char);

			}

			// restore previous values

			if (!$this->empty_string($fontname)) {

				$this->SetFont($prev_FontFamily, $prev_FontStyle, $prev_FontSizePt);

			}

			return $w;

		}

		

		/**

		* Returns the length of the char in user unit for the current font.<br>

		* @param int $char The char code whose length is to be returned

		* @return int char width

		* @author Nicola Asuni

		* @access public

		* @since 2.4.000 (2008-03-06)

		*/

		public function GetCharWidth($char) {

			if ($char == 173) {

				// SHY character will not be printed

				return (0);

			}

			$cw = &$this->CurrentFont['cw'];

			if (isset($cw[$char])) {

				$w = $cw[$char];

			} elseif (isset($this->CurrentFont['dw'])) {

				// default width

				$w = $this->CurrentFont['dw'];

			} elseif (isset($cw[32])) {

				// default width

				$dw = $cw[32];

			} else {

				$w = 600;

			}

			return ($w * $this->FontSize / 1000);

		}

		

		/**

		* Returns the numbero of characters in a string.

		* @param string $s The input string.

		* @return int number of characters

		* @access public

		* @since 2.0.0001 (2008-01-07)

		*/

		public function GetNumChars($s) {

			if (($this->CurrentFont['type'] == 'TrueTypeUnicode') OR ($this->CurrentFont['type'] == 'cidfont0')) {

				return count($this->UTF8StringToArray($s));

			} 

			return strlen($s);

		}

			

		/**

		* Fill the list of available fonts ($this->fontlist).

		* @access protected

		* @since 4.0.013 (2008-07-28)

		*/

		protected function getFontsList() {

			$fontsdir = opendir($this->_getfontpath());

			while (($file = readdir($fontsdir)) !== false) {

				if (substr($file, -4) == '.php') {

					array_push($this->fontlist, strtolower(basename($file, '.php')));

				}

			}

			closedir($fontsdir);

		}

		

		/**

		* Imports a TrueType, Type1, core, or CID0 font and makes it available.

		* It is necessary to generate a font definition file first (read /fonts/utils/README.TXT). 

		* The definition file (and the font file itself when embedding) must be present either in the current directory or in the one indicated by K_PATH_FONTS if the constant is defined. If it could not be found, the error "Could not include font definition file" is generated.

		* @param string $family Font family. The name can be chosen arbitrarily. If it is a standard family name, it will override the corresponding font.

		* @param string $style Font style. Possible values are (case insensitive):<ul><li>empty string: regular (default)</li><li>B: bold</li><li>I: italic</li><li>BI or IB: bold italic</li></ul>

		* @param string $fontfile The font definition file. By default, the name is built from the family and style, in lower case with no spaces.

		* @return array containing the font data, or false in case of error.

		* @access public

		* @since 1.5

		* @see SetFont()

		*/

		public function AddFont($family, $style='', $fontfile='') {

			if ($this->empty_string($family)) {

				if (!$this->empty_string($this->FontFamily)) {

					$family = $this->FontFamily;

				} else {

					$this->Error('Empty font family');

				}

			}

			$family = strtolower($family);

			if ((!$this->isunicode) AND ($family == 'arial')) {

				$family = 'helvetica';

			}

			if (($family == 'symbol') OR ($family == 'zapfdingbats')) {

				$style = '';

			}

			$tempstyle = strtoupper($style);

			$style = '';

			// underline

			if (strpos($tempstyle, 'U') !== false) {

				$this->underline = true;

			} else {

				$this->underline = false;

			}

			// line through (deleted)

			if (strpos($tempstyle, 'D') !== false) {

				$this->linethrough = true;

			} else {

				$this->linethrough = false;

			}

			// bold

			if (strpos($tempstyle, 'B') !== false) {

				$style .= 'B';

			}

			// oblique

			if (strpos($tempstyle, 'I') !== false) {

				$style .= 'I';

			}

			$bistyle = $style;

			$fontkey = $family.$style;

			$font_style = $style.($this->underline ? 'U' : '').($this->linethrough ? 'D' : '');

			$fontdata = array('fontkey' => $fontkey, 'family' => $family, 'style' => $font_style);

			// check if the font has been already added

			if ($this->getFontBuffer($fontkey) !== false) {

				return $fontdata;

			}

			if (isset($type)) {

				unset($type); 

			}

			if (isset($cw)) {

				unset($cw); 

			}

			// get specified font directory (if any)

			$fontdir = '';

			if (!$this->empty_string($fontfile)) {

				$fontdir = dirname($fontfile);

				if ($this->empty_string($fontdir) OR ($fontdir == '.')) {

					$fontdir = '';

				} else {

					$fontdir .= '/';

				}

			}

			// search and include font file

			if ($this->empty_string($fontfile) OR (!file_exists($fontfile))) {

				// build a standard filenames for specified font

				$fontfile1 = str_replace(' ', '', $family).strtolower($style).'.php';

				$fontfile2 = str_replace(' ', '', $family).'.php';

				// search files on various directories

				if (file_exists($fontdir.$fontfile1)) {

					$fontfile = $fontdir.$fontfile1;

				} elseif (file_exists($this->_getfontpath().$fontfile1)) {

					$fontfile = $this->_getfontpath().$fontfile1;

				} elseif (file_exists($fontfile1)) {

					$fontfile = $fontfile1;

				} elseif (file_exists($fontdir.$fontfile2)) {

					$fontfile = $fontdir.$fontfile2;

				} elseif (file_exists($this->_getfontpath().$fontfile2)) {

					$fontfile = $this->_getfontpath().$fontfile2;

				} else {

					$fontfile = $fontfile2;

				}

			}

			// include font file

			if (file_exists($fontfile)) {

				include($fontfile);

			} else {

				$this->Error('Could not include font definition file: '.$family.'');

			}

			// check font parameters

			if ((!isset($type)) OR (!isset($cw))) {

				$this->Error('The font definition file has a bad format: '.$fontfile.'');

			}

			if (!isset($file)) {

				$file = '';

			}

			if (!isset($enc)) {

				$enc = '';

			}

			if (!isset($dw) OR $this->empty_string($dw)) {

				// set default width

				if (isset($desc['MissingWidth']) AND ($desc['MissingWidth'] > 0)) {

					$dw = $desc['MissingWidth'];

				} elseif (isset($cw[32])) {

					$dw = $cw[32];

				} else {

					$dw = 600;

				}

			}

			++$this->numfonts;			

			// register CID font (all styles at once)

			if ($type == 'cidfont0') {

				$file = ''; // not embedded

				$styles = array('' => '', 'B' => ',Bold', 'I' => ',Italic', 'BI' => ',BoldItalic');

				$sname = $name.$styles[$bistyle];

				if ((strpos($bistyle, 'B') !== false) AND (isset($desc['StemV'])) AND ($desc['StemV'] == 70)) {

					$desc['StemV'] = 120;

				}

				$this->setFontBuffer($fontkey, array('i' => $this->numfonts, 'type' => $type, 'name' => $sname, 'desc' => $desc, 'cidinfo' => $cidinfo, 'up' => $up, 'ut' => $ut, 'cw' => $cw, 'dw' => $dw, 'enc' => $enc));

			} elseif ($type == 'core') {

				$this->setFontBuffer($fontkey, array('i' => $this->numfonts, 'type' => 'core', 'name' => $this->CoreFonts[$fontkey], 'up' => -100, 'ut' => 50, 'cw' => $cw, 'dw' => $dw));

			} elseif (($type == 'TrueType') OR ($type == 'Type1')) {

				$this->setFontBuffer($fontkey, array('i' => $this->numfonts, 'type' => $type, 'name' => $name, 'up' => $up, 'ut' => $ut, 'cw' => $cw, 'dw' => $dw, 'file' => $file, 'enc' => $enc, 'desc' => $desc));

			} elseif ($type == 'TrueTypeUnicode') {

				$this->setFontBuffer($fontkey, array('i' => $this->numfonts, 'type' => $type, 'name' => $name, 'desc' => $desc, 'up' => $up, 'ut' => $ut, 'cw' => $cw, 'dw' => $dw, 'enc' => $enc, 'file' => $file, 'ctg' => $ctg));

			} else {

				$this->Error('Unknow font type: '.$type.'');

			}

			if (isset($diff) AND (!empty($diff))) {

				//Search existing encodings

				$d = 0;

				$nb = count($this->diffs);

				for ($i=1; $i <= $nb; ++$i) {

					if ($this->diffs[$i] == $diff) {

						$d = $i;

						break;

					}

				}

				if ($d == 0) {

					$d = $nb + 1;

					$this->diffs[$d] = $diff;

				}

				$this->setFontSubBuffer($fontkey, 'diff', $d);

			}

			if (!$this->empty_string($file)) {

				if ((strcasecmp($type,'TrueType') == 0) OR (strcasecmp($type, 'TrueTypeUnicode') == 0)) {

					$this->FontFiles[$file] = array('length1' => $originalsize, 'fontdir' => $fontdir);

				} elseif ($type != 'core') {

					$this->FontFiles[$file] = array('length1' => $size1, 'length2' => $size2, 'fontdir' => $fontdir);

				}

			}

			return $fontdata;

		}



		/**

		* Sets the font used to print character strings. 

		* The font can be either a standard one or a font added via the AddFont() method. Standard fonts use Windows encoding cp1252 (Western Europe).

		* The method can be called before the first page is created and the font is retained from page to page. 

		* If you just wish to change the current font size, it is simpler to call SetFontSize().

		* Note: for the standard fonts, the font metric files must be accessible. There are three possibilities for this:<ul><li>They are in the current directory (the one where the running script lies)</li><li>They are in one of the directories defined by the include_path parameter</li><li>They are in the directory defined by the K_PATH_FONTS constant</li></ul><br />

		* @param string $family Family font. It can be either a name defined by AddFont() or one of the standard Type1 families (case insensitive):<ul><li>times (Times-Roman)</li><li>timesb (Times-Bold)</li><li>timesi (Times-Italic)</li><li>timesbi (Times-BoldItalic)</li><li>helvetica (Helvetica)</li><li>helveticab (Helvetica-Bold)</li><li>helveticai (Helvetica-Oblique)</li><li>helveticabi (Helvetica-BoldOblique)</li><li>courier (Courier)</li><li>courierb (Courier-Bold)</li><li>courieri (Courier-Oblique)</li><li>courierbi (Courier-BoldOblique)</li><li>symbol (Symbol)</li><li>zapfdingbats (ZapfDingbats)</li></ul> It is also possible to pass an empty string. In that case, the current family is retained.

		* @param string $style Font style. Possible values are (case insensitive):<ul><li>empty string: regular</li><li>B: bold</li><li>I: italic</li><li>U: underline</li><li>D: line trough</li></ul> or any combination. The default value is regular. Bold and italic styles do not apply to Symbol and ZapfDingbats basic fonts or other fonts when not defined.

		* @param float $size Font size in points. The default value is the current size. If no size has been specified since the beginning of the document, the value taken is 12

		* @param string $fontfile The font definition file. By default, the name is built from the family and style, in lower case with no spaces.

		* @access public

		* @since 1.0

		* @see AddFont(), SetFontSize()

		*/

		public function SetFont($family, $style='', $size=0, $fontfile='') {

			//Select a font; size given in points

			if ($size == 0) {

				$size = $this->FontSizePt;

			}

			// try to add font (if not already added)

			$fontdata = $this->AddFont($family, $style, $fontfile);

			$this->FontFamily = $fontdata['family'];

			$this->FontStyle = $fontdata['style'];

			$this->CurrentFont = $this->getFontBuffer($fontdata['fontkey']);

			$this->SetFontSize($size);

		}



		/**

		* Defines the size of the current font.

		* @param float $size The size (in points)

		* @access public

		* @since 1.0

		* @see SetFont()

		*/

		public function SetFontSize($size) {

			//Set font size in points

			$this->FontSizePt = $size;

			$this->FontSize = $size / $this->k;

			if (isset($this->CurrentFont['desc']['Ascent']) AND ($this->CurrentFont['desc']['Ascent'] > 0)) {

				$this->FontAscent = $this->CurrentFont['desc']['Ascent'] * $this->FontSize / 1000;

			} else {

				$this->FontAscent = 0.8 * $this->FontSize;

			}

			if (isset($this->CurrentFont['desc']['Descent']) AND ($this->CurrentFont['desc']['Descent'] > 0)) {

				$this->FontDescent = - $this->CurrentFont['desc']['Descent'] * $this->FontSize / 1000;

			} else {

				$this->FontDescent = 0.2 * $this->FontSize;

			}

			if (($this->page > 0) AND (isset($this->CurrentFont['i']))) {

				$this->_out(sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));

			}

		}



		/**

		* Defines the default monospaced font.

		* @param string $font Font name.

		* @access public

		* @since 4.5.025

		*/

		public function SetDefaultMonospacedFont($font) {

			$this->default_monospaced_font = $font;

		}

		

		/**

		* Creates a new internal link and returns its identifier. An internal link is a clickable area which directs to another place within the document.<br />

		* The identifier can then be passed to Cell(), Write(), Image() or Link(). The destination is defined with SetLink().

		* @access public

		* @since 1.5

		* @see Cell(), Write(), Image(), Link(), SetLink()

		*/

		public function AddLink() {

			//Create a new internal link

			$n = count($this->links) + 1;

			$this->links[$n] = array(0, 0);

			return $n;

		}



		/**

		* Defines the page and position a link points to.

		* @param int $link The link identifier returned by AddLink()

		* @param float $y Ordinate of target position; -1 indicates the current position. The default value is 0 (top of page)

		* @param int $page Number of target page; -1 indicates the current page. This is the default value

		* @access public

		* @since 1.5

		* @see AddLink()

		*/

		public function SetLink($link, $y=0, $page=-1) {

			if ($y == -1) {

				$y = $this->y;

			}

			if ($page == -1) {

				$page = $this->page;

			}

			$this->links[$link] = array($page, $y);

		}



		/**

		* Puts a link on a rectangular area of the page.

		* Text or image links are generally put via Cell(), Write() or Image(), but this method can be useful for instance to define a clickable area inside an image.

		* @param float $x Abscissa of the upper-left corner of the rectangle

		* @param float $y Ordinate of the upper-left corner of the rectangle

		* @param float $w Width of the rectangle

		* @param float $h Height of the rectangle

		* @param mixed $link URL or identifier returned by AddLink()

		* @param int $spaces number of spaces on the text to link

		* @access public

		* @since 1.5

		* @see AddLink(), Annotation(), Cell(), Write(), Image()

		*/

		public function Link($x, $y, $w, $h, $link, $spaces=0) {

			$this->Annotation($x, $y, $w, $h, $link, array('Subtype'=>'Link'), $spaces);

		}

		

		/**

		* Puts a markup annotation on a rectangular area of the page.

		* !!!!THE ANNOTATION SUPPORT IS NOT YET FULLY IMPLEMENTED !!!!

		* @param float $x Abscissa of the upper-left corner of the rectangle

		* @param float $y Ordinate of the upper-left corner of the rectangle

		* @param float $w Width of the rectangle

		* @param float $h Height of the rectangle

		* @param string $text annotation text or alternate content

		* @param array $opt array of options (see section 8.4 of PDF reference 1.7).

		* @param int $spaces number of spaces on the text to link

		* @access public

		* @since 4.0.018 (2008-08-06)

		*/

		public function Annotation($x, $y, $w, $h, $text, $opt=array('Subtype'=>'Text'), $spaces=0) {

			// recalculate coordinates to account for graphic transformations

			if (isset($this->transfmatrix)) {

				$maxid = count($this->transfmatrix) - 1;

				for ($i=$maxid; $i >= 0; $i--) {

					$ctm = $this->transfmatrix[$i];

					if (isset($ctm['a'])) {

						$x = $x * $this->k;

						$y = ($this->h - $y) * $this->k;

						$w = $w * $this->k;

						$h = $h * $this->k;

						// top left

						$xt = $x;

						$yt = $y;

						$x1 = ($ctm['a'] * $xt) + ($ctm['c'] * $yt) + $ctm['e'];

						$y1 = ($ctm['b'] * $xt) + ($ctm['d'] * $yt) + $ctm['f'];

						// top right

						$xt = $x + $w;

						$yt = $y;

						$x2 = ($ctm['a'] * $xt) + ($ctm['c'] * $yt) + $ctm['e'];

						$y2 = ($ctm['b'] * $xt) + ($ctm['d'] * $yt) + $ctm['f'];

						// bottom left

						$xt = $x;

						$yt = $y - $h;

						$x3 = ($ctm['a'] * $xt) + ($ctm['c'] * $yt) + $ctm['e'];

						$y3 = ($ctm['b'] * $xt) + ($ctm['d'] * $yt) + $ctm['f'];

						// bottom right

						$xt = $x + $w;

						$yt = $y - $h;

						$x4 = ($ctm['a'] * $xt) + ($ctm['c'] * $yt) + $ctm['e'];

						$y4 = ($ctm['b'] * $xt) + ($ctm['d'] * $yt) + $ctm['f'];

						// new coordinates (rectangle area)

						$x = min($x1, $x2, $x3, $x4);

						$y = max($y1, $y2, $y3, $y4);

						$w = (max($x1, $x2, $x3, $x4) - $x) / $this->k;

						$h = ($y - min($y1, $y2, $y3, $y4)) / $this->k;

						$x = $x / $this->k;

						$y = $this->h - ($y / $this->k);

					}

				}

			}

			$this->PageAnnots[$this->page][] = array('x' => $x, 'y' => $y, 'w' => $w, 'h' => $h, 'txt' => $text, 'opt' => $opt, 'numspaces' => $spaces);

			if (($opt['Subtype'] == 'FileAttachment') AND (!$this->empty_string($opt['FS'])) AND file_exists($opt['FS']) AND (!isset($this->embeddedfiles[basename($opt['FS'])]))) {

				$this->embeddedfiles[basename($opt['FS'])] = array('file' => $opt['FS'], 'n' => (count($this->embeddedfiles) + 100000));

			}

		}



		/**

		* Embedd the attached files.

		* @since 4.4.000 (2008-12-07)

		* @access protected

		* @see Annotation()

		*/

		protected function _putEmbeddedFiles() {

			reset($this->embeddedfiles);

			foreach ($this->embeddedfiles as $filename => $filedata) {

				$data = file_get_contents($filedata['file']);

				$filter = '';

				if ($this->compress) {

					$data = gzcompress($data);

					$filter = ' /Filter /FlateDecode';

				}

				$this->offsets[$filedata['n']] = $this->bufferlen;

				$this->_out($filedata['n'].' 0 obj');

				$this->_out('<</Type /EmbeddedFile'.$filter.' /Length '.strlen($data).' >>');

				$this->_putstream($data);

				$this->_out('endobj');

			}

		}

		

		/**

		* Prints a character string.

		* The origin is on the left of the first charcter, on the baseline.

		* This method allows to place a string precisely on the page.

		* @param float $x Abscissa of the origin

		* @param float $y Ordinate of the origin

		* @param string $txt String to print

		* @param int $stroke outline size in points (0 = disable)

		* @param boolean $clip if true activate clipping mode (you must call StartTransform() before this function and StopTransform() to stop the clipping tranformation).

		* @access public

		* @since 1.0

		* @deprecated deprecated since version 4.3.005 (2008-11-25)

		* @see Cell(), Write(), MultiCell(), WriteHTML(), WriteHTMLCell()

		*/

		public function Text($x, $y, $txt, $stroke=0, $clip=false) {

			//Output a string

			if ($this->rtl) {

				// bidirectional algorithm (some chars may be changed affecting the line length)

				$s = $this->utf8Bidi($this->UTF8StringToArray($txt), $txt, $this->tmprtl);

				$l = $this->GetArrStringWidth($s);

				$xr = $this->w - $x - $this->GetArrStringWidth($s);

			} else {

				$xr = $x;

			}

			$opt = '';

			if (($stroke > 0) AND (!$clip)) {

				$opt .= '1 Tr '.intval($stroke).' w ';

			} elseif (($stroke > 0) AND $clip) {

				$opt .= '5 Tr '.intval($stroke).' w ';

			} elseif ($clip) {

				$opt .= '7 Tr ';

			}

			$s = sprintf('BT %.2F %.2F Td %s(%s) Tj ET 0 Tr', $xr * $this->k, ($this->h-$y) * $this->k, $opt, $this->_escapetext($txt));

			if ($this->underline AND ($txt!='')) {

				$s .= ' '.$this->_dounderline($xr, $y, $txt);

			}

			if ($this->linethrough AND ($txt!='')) { 

				$s .= ' '.$this->_dolinethrough($xr, $y, $txt); 

			}

			if ($this->ColorFlag AND (!$clip)) {

				$s='q '.$this->TextColor.' '.$s.' Q';

			}

			$this->_out($s);

		}



		/**

		* Whenever a page break condition is met, the method is called, and the break is issued or not depending on the returned value. 

		* The default implementation returns a value according to the mode selected by SetAutoPageBreak().<br />

		* This method is called automatically and should not be called directly by the application.

		* @return boolean

		* @access public

		* @since 1.4

		* @see SetAutoPageBreak()

		*/

		public function AcceptPageBreak() {

			return $this->AutoPageBreak;

		}

		

		/**

		* Add page if needed.

		* @param float $h Cell height. Default value: 0.

		* @param mixed $y starting y position, leave empty for current position.

		* @return boolean true in case of page break, false otherwise.

		* @since 3.2.000 (2008-07-01)

		* @access protected

		*/

		protected function checkPageBreak($h=0, $y='') {

			if ($this->empty_string($y)) {

				$y = $this->y;

			}

			if ((($y + $h) > $this->PageBreakTrigger) AND (!$this->InFooter) AND ($this->AcceptPageBreak())) {

				//Automatic page break

				$x = $this->x;

				$this->AddPage($this->CurOrientation);

				$this->y = $this->tMargin;

				$oldpage = $this->page - 1;

				if ($this->rtl) {

					if ($this->pagedim[$this->page]['orm'] != $this->pagedim[$oldpage]['orm']) {

						$this->x = $x - ($this->pagedim[$this->page]['orm'] - $this->pagedim[$oldpage]['orm']);

					} else {

						$this->x = $x;

					}

				} else {

					if ($this->pagedim[$this->page]['olm'] != $this->pagedim[$oldpage]['olm']) {

						$this->x = $x + ($this->pagedim[$this->page]['olm'] - $this->pagedim[$oldpage]['olm']);

					} else {

						$this->x = $x;

					}

				}

				return true;

			}

			return false;

		}



		/**

		* Prints a cell (rectangular area) with optional borders, background color and character string. The upper-left corner of the cell corresponds to the current position. The text can be aligned or centered. After the call, the current position moves to the right or to the next line. It is possible to put a link on the text.<br />

		* If automatic page breaking is enabled and the cell goes beyond the limit, a page break is done before outputting.

		* @param float $w Cell width. If 0, the cell extends up to the right margin.

		* @param float $h Cell height. Default value: 0.

		* @param string $txt String to print. Default value: empty string.

		* @param mixed $border Indicates if borders must be drawn around the cell. The value can be either a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul>or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul>

		* @param int $ln Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right (or left for RTL languages)</li><li>1: to the beginning of the next line</li><li>2: below</li></ul>

		Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0.

		* @param string $align Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>

		* @param int $fill Indicates if the cell background must be painted (1) or transparent (0). Default value: 0.

		* @param mixed $link URL or identifier returned by AddLink().

		* @param int $stretch stretch carachter mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if necessary</li><li>2 = forced horizontal scaling</li><li>3 = character spacing only if necessary</li><li>4 = forced character spacing</li></ul>

		* @param boolean $ignore_min_height if true ignore automatic minimum height value.

		* @access public

		* @since 1.0

		* @see SetFont(), SetDrawColor(), SetFillColor(), SetTextColor(), SetLineWidth(), AddLink(), Ln(), MultiCell(), Write(), SetAutoPageBreak()

		*/

		public function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false) {

			//$min_cell_height = $this->FontAscent + $this->FontDescent;

			$min_cell_height = $this->FontSize * $this->cell_height_ratio;

			if ($h < $min_cell_height) {

				$h = $min_cell_height;

			}

			$this->checkPageBreak($h);

			$this->_out($this->getCellCode($w, $h, $txt, $border, $ln, $align, $fill, $link, $stretch, $ignore_min_height));

		}



		/**

		* Removes SHY characters from text.

		* @param string $txt input string

		* @return string without SHY characters.

		* @access public

		* @since (4.5.019) 2009-02-28

		*/

		public function removeSHY($txt='') {

			/*

			* Unicode Data

			* Name : SOFT HYPHEN, commonly abbreviated as SHY

			* HTML Entity (decimal): &#173;

			* HTML Entity (hex): &#xad;

			* HTML Entity (named): &shy;

			* How to type in Microsoft Windows: [Alt +00AD] or [Alt 0173]

			* UTF-8 (hex): 0xC2 0xAD (c2ad)

			* UTF-8 character: chr(194).chr(173)

			*/

			$txt = preg_replace('/([\\xc2]{1}[\\xad]{1})/', '', $txt);

			if (!$this->isunicode) {

				$txt = preg_replace('/([\\xad]{1})/', '', $txt);

			}

			return $txt;

		}

		

		/**

		* Returns the PDF string code to print a cell (rectangular area) with optional borders, background color and character string. The upper-left corner of the cell corresponds to the current position. The text can be aligned or centered. After the call, the current position moves to the right or to the next line. It is possible to put a link on the text.<br />

		* If automatic page breaking is enabled and the cell goes beyond the limit, a page break is done before outputting.

		* @param float $w Cell width. If 0, the cell extends up to the right margin.

		* @param float $h Cell height. Default value: 0.

		* @param string $txt String to print. Default value: empty string.

		* @param mixed $border Indicates if borders must be drawn around the cell. The value can be either a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul>or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul>

		* @param int $ln Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right (or left for RTL languages)</li><li>1: to the beginning of the next line</li><li>2: below</li></ul>Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0.

		* @param string $align Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>

		* @param int $fill Indicates if the cell background must be painted (1) or transparent (0). Default value: 0.

		* @param mixed $link URL or identifier returned by AddLink().

		* @param int $stretch stretch carachter mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if necessary</li><li>2 = forced horizontal scaling</li><li>3 = character spacing only if necessary</li><li>4 = forced character spacing</li></ul>

		* @param boolean $ignore_min_height if true ignore automatic minimum height value.

		* @access protected

		* @since 1.0

		* @see Cell()

		*/

		protected function getCellCode($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false) {

			$txt = $this->removeSHY($txt);

			$rs = ''; //string to be returned

			if (!$ignore_min_height) {

				$min_cell_height = $this->FontSize * $this->cell_height_ratio;

				if ($h < $min_cell_height) {

					$h = $min_cell_height;

				}

			}

			$k = $this->k;

			if ($this->empty_string($w) OR ($w <= 0)) {

				if ($this->rtl) {

					$w = $this->x - $this->lMargin;

				} else {

					$w = $this->w - $this->rMargin - $this->x;

				}

			}

			$s = '';			

			if (($fill == 1) OR ($border == 1)) {

				if ($fill == 1) {

					$op = ($border == 1) ? 'B' : 'f';

				} else {

					$op = 'S';

				}

				if ($this->rtl) {

					$xk = (($this->x  - $w) * $k);

				} else {

					$xk = ($this->x * $k);

				}

				$s .= sprintf('%.2F %.2F %.2F %.2F re %s ', $xk, (($this->h - $this->y) * $k), ($w * $k), (-$h * $k), $op);

			}

			if (is_string($border)) {

				$lm = ($this->LineWidth / 2);

				$x = $this->x;

				$y = $this->y;

				if (strpos($border,'L') !== false) {

					if ($this->rtl) {

						$xk = ($x - $w) * $k;

					} else {

						$xk = $x * $k;

					}

					$s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $xk, (($this->h - $y + $lm) * $k), $xk, (($this->h - ($y + $h + $lm)) * $k));

				}

				if (strpos($border,'T') !== false) {

					if ($this->rtl) {

						$xk = ($x - $w + $lm) * $k;

						$xwk = ($x - $lm) * $k;

					} else {

						$xk = ($x - $lm) * $k;

						$xwk = ($x + $w + $lm) * $k;

					}

					$s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $xk, (($this->h - $y) * $k), $xwk, (($this->h - $y) * $k));

				}

				if (strpos($border,'R') !== false) {

					if ($this->rtl) {

						$xk = $x * $k;

					} else {

						$xk = ($x + $w) * $k;

					}

					$s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $xk, (($this->h - $y + $lm) * $k), $xk, (($this->h - ($y + $h + $lm))* $k));

				}

				if (strpos($border,'B') !== false) {

					if ($this->rtl) {

						$xk = ($x - $w + $lm) * $k;

						$xwk = ($x - $lm) * $k;

					} else {

						$xk = ($x - $lm) * $k;

						$xwk = ($x + $w + $lm) * $k;

					}

					$s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $xk, (($this->h - ($y + $h)) * $k), $xwk, (($this->h - ($y + $h)) * $k));

				}

			}

			if ($txt != '') {

				// text lenght

				$width = $this->GetStringWidth($txt);

				// ratio between cell lenght and text lenght

				$ratio = ($w - (2 * $this->cMargin)) / $width;

				

				// stretch text if required

				if (($stretch > 0) AND (($ratio < 1) OR (($ratio > 1) AND (($stretch % 2) == 0)))) {

					if ($stretch > 2) {

						// spacing

						//Calculate character spacing in points

						$char_space = (($w - $width - (2 * $this->cMargin)) * $this->k) / max($this->GetNumChars($txt)-1,1);

						//Set character spacing

						$rs .= sprintf('BT %.2F Tc ET ', $char_space);

					} else {

						// scaling

						//Calculate horizontal scaling

						$horiz_scale = $ratio * 100.0;

						//Set horizontal scaling

						$rs .= sprintf('BT %.2F Tz ET ', $horiz_scale);

					}

					$align = '';

					$width = $w - (2 * $this->cMargin);

				} else {

					$stretch == 0;

				}

				if ($align == 'L') {

					if ($this->rtl) {

						$dx = $w - $width - $this->cMargin;

					} else {

						$dx = $this->cMargin;

					}

				} elseif ($align == 'R') {

					if ($this->rtl) {

						$dx = $this->cMargin;

					} else {

						$dx = $w - $width - $this->cMargin;

					}

				} elseif ($align == 'C') {

					$dx = ($w - $width) / 2;

				} elseif ($align == 'J') {

					if ($this->rtl) {

						$dx = $w - $width - $this->cMargin;

					} else {

						$dx = $this->cMargin;

					}

				} else {

					$dx = $this->cMargin;

				}

				if ($this->ColorFlag) {

					$s .= 'q '.$this->TextColor.' ';

				}

				$txt2 = $this->_escapetext($txt);

				if ($this->rtl) {

					$xdk = ($this->x - $dx - $width) * $k;

				} else {

					$xdk = ($this->x + $dx) * $k;

				}

				// Justification

				if ($align == 'J') {

					// count number of spaces

					$ns = substr_count($txt, ' ');

					if (($this->CurrentFont['type'] == 'TrueTypeUnicode') OR ($this->CurrentFont['type'] == 'cidfont0')) {

						// get string width without spaces

						$width = $this->GetStringWidth(str_replace(' ', '', $txt));

						// calculate average space width

						$spacewidth = ($w - $width - (2 * $this->cMargin)) / ($ns?$ns:1) / $this->FontSize / $this->k;

						// set word position to be used with TJ operator

						$txt2 = str_replace(chr(0).' ', ') '.(-2830 * $spacewidth).' (', $txt2);

					} else {

						// get string width

						$width = $this->GetStringWidth($txt);

						$spacewidth = (($w - $width - (2 * $this->cMargin)) / ($ns?$ns:1)) * $this->k;

						$rs .= sprintf('BT %.3F Tw ET ', $spacewidth);

					}

				}

				// calculate approximate position of the font base line

				//$basefonty = $this->y + (($h + $this->FontAscent - $this->FontDescent)/2);

				$basefonty = $this->y + ($h/2) + ($this->FontSize/3);

				// print text

				$s .= sprintf('BT %.2F %.2F Td [(%s)] TJ ET', $xdk, (($this->h - $basefonty) * $k), $txt2);

				if ($this->rtl) {

					$xdx = $this->x - $dx - $width;

				} else {

					$xdx = $this->x + $dx;

				}

				if ($this->underline)  {

					$s .= ' '.$this->_dounderline($xdx, $basefonty, $txt);

				}

				if ($this->linethrough) { 

					$s .= ' '.$this->_dolinethrough($xdx, $basefonty, $txt);

				}

				if ($this->ColorFlag) {

					$s .= ' Q';

				}

				if ($link) {

					$this->Link($xdx, $this->y + (($h - $this->FontSize)/2), $width, $this->FontSize, $link, substr_count($txt, chr(32)));

				}

			}

			// output cell

			if ($s) {

				// output cell

				$rs .= $s;

				// reset text stretching

				if ($stretch > 2) {

					//Reset character horizontal spacing

					$rs .= ' BT 0 Tc ET';

				} elseif ($stretch > 0) {

					//Reset character horizontal scaling

					$rs .= ' BT 100 Tz ET';

				}

			}

			// reset word spacing

			if (!(($this->CurrentFont['type'] == 'TrueTypeUnicode') OR ($this->CurrentFont['type'] == 'cidfont0')) AND ($align == 'J')) {

				$rs .= ' BT 0 Tw ET';

			}

			$this->lasth = $h;

			if ($ln > 0) {

				//Go to the beginning of the next line

				$this->y += $h;

				if ($ln == 1) {

					if ($this->rtl) {

						$this->x = $this->w - $this->rMargin;

					} else {

						$this->x = $this->lMargin;

					}

				}

			} else {

				// go left or right by case

				if ($this->rtl) {

					$this->x -= $w;

				} else {

					$this->x += $w;

				}

			}

			$gstyles = ''.$this->linestyleWidth.' '.$this->linestyleCap.' '.$this->linestyleJoin.' '.$this->linestyleDash.' '.$this->DrawColor.' '.$this->FillColor."\n";

			$rs = $gstyles.$rs;

			return $rs;

		}



		/**

		* This method allows printing text with line breaks. 

		* They can be automatic (as soon as the text reaches the right border of the cell) or explicit (via the \n character). As many cells as necessary are output, one below the other.<br />

		* Text can be aligned, centered or justified. The cell block can be framed and the background painted.

		* @param float $w Width of cells. If 0, they extend up to the right margin of the page.

		* @param float $h Cell minimum height. The cell extends automatically if needed.

		* @param string $txt String to print

		* @param mixed $border Indicates if borders must be drawn around the cell block. The value can be either a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul>or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul>

		* @param string $align Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align</li><li>C: center</li><li>R: right align</li><li>J: justification (default value when $ishtml=false)</li></ul>

		* @param int $fill Indicates if the cell background must be painted (1) or transparent (0). Default value: 0.

		* @param int $ln Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right</li><li>1: to the beginning of the next line [DEFAULT]</li><li>2: below</li></ul>

		* @param int $x x position in user units

		* @param int $y y position in user units

		* @param boolean $reseth if true reset the last cell height (default true).

		* @param int $stretch stretch carachter mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if necessary</li><li>2 = forced horizontal scaling</li><li>3 = character spacing only if necessary</li><li>4 = forced character spacing</li></ul>

		* @param boolean $ishtml set to true if $txt is HTML content (default = false).

		* @param boolean $autopadding if true, uses internal padding and automatically adjust it to account for line width.

		* @param float $maxh maximum height. It should be >= $h and less then remaining space to the bottom of the page, or 0 for disable this feature. This feature works only when $ishtml=false.

		* @return int Return the number of cells or 1 for html mode.

		* @access public

		* @since 1.3

		* @see SetFont(), SetDrawColor(), SetFillColor(), SetTextColor(), SetLineWidth(), Cell(), Write(), SetAutoPageBreak()

		*/

		public function MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0) {	

			if ($this->empty_string($this->lasth) OR $reseth) {

				//set row height

				$this->lasth = $this->FontSize * $this->cell_height_ratio;

			}

			if (!$this->empty_string($y)) {

				$this->SetY($y);

			} else {

				$y = $this->GetY();

			}

			// check for page break

			$this->checkPageBreak($h);

			$y = $this->GetY();

			// get current page number

			$startpage = $this->page;

			if (!$this->empty_string($x)) {

				$this->SetX($x);

			} else {

				$x = $this->GetX();

			}

			if ($this->empty_string($w) OR ($w <= 0)) {

				if ($this->rtl) {

					$w = $this->x - $this->lMargin;

				} else {

					$w = $this->w - $this->rMargin - $this->x;

				}

			}

			// store original margin values

			$lMargin = $this->lMargin;

			$rMargin = $this->rMargin;

			if ($this->rtl) {

				$this->SetRightMargin($this->w - $this->x);

				$this->SetLeftMargin($this->x - $w);

			} else {

				$this->SetLeftMargin($this->x);

				$this->SetRightMargin($this->w - $this->x - $w);

			}

			$starty = $this->y;

			if ($autopadding) {

				// Adjust internal padding

				if ($this->cMargin < ($this->LineWidth / 2)) {

					$this->cMargin = ($this->LineWidth / 2);

				}

				// Add top space if needed

				if (($this->lasth - $this->FontSize) < $this->LineWidth) {

					$this->y += $this->LineWidth / 2;

				}

				// add top padding

				$this->y += $this->cMargin;

			}

			if ($ishtml) {

				// ******* Write HTML text

				$this->writeHTML($txt, true, 0, $reseth, true, $align);

				$nl = 1;

			} else {

				// ******* Write text

				$nl = $this->Write($this->lasth, $txt, '', 0, $align, true, $stretch, false, false, $maxh);

			}

			if ($autopadding) {

				// add bottom padding

				$this->y += $this->cMargin;

				// Add bottom space if needed

				if (($this->lasth - $this->FontSize) < $this->LineWidth) {

					$this->y += $this->LineWidth / 2;

				}

			}

			// Get end-of-text Y position

			$currentY = $this->y;

			// get latest page number

			$endpage = $this->page;

			// check if a new page has been created

			if ($endpage > $startpage) {

				// design borders around HTML cells.

				for ($page=$startpage; $page <= $endpage; ++$page) {

					$this->setPage($page);

					if ($page == $startpage) {

						$this->y = $starty; // put cursor at the beginning of cell on the first page

						$h = $this->getPageHeight() - $starty - $this->getBreakMargin();

						$cborder = $this->getBorderMode($border, $position='start');

					} elseif ($page == $endpage) {

						$this->y = $this->tMargin; // put cursor at the beginning of last page

						$h = $currentY - $this->tMargin;

						$cborder = $this->getBorderMode($border, $position='end');

					} else {

						$this->y = $this->tMargin; // put cursor at the beginning of the current page

						$h = $this->getPageHeight() - $this->tMargin - $this->getBreakMargin();

						$cborder = $this->getBorderMode($border, $position='middle');

					}

					$nx = $x;

					// account for margin changes

					if ($page > $startpage) {

						if (($this->rtl) AND ($this->pagedim[$page]['orm'] != $this->pagedim[$startpage]['orm'])) {

							$nx = $x + ($this->pagedim[$page]['orm'] - $this->pagedim[$startpage]['orm']);

						} elseif ((!$this->rtl) AND ($this->pagedim[$page]['olm'] != $this->pagedim[$startpage]['olm'])) {

							$nx = $x + ($this->pagedim[$page]['olm'] - $this->pagedim[$startpage]['olm']);

						}

					}

					$this->SetX($nx);

					$ccode = $this->getCellCode($w, $h, '', $cborder, 1, '', $fill, '', 0, false);

					if ($cborder OR $fill) {

						$pagebuff = $this->getPageBuffer($this->page);

						$pstart = substr($pagebuff, 0, $this->intmrk[$this->page]);

						$pend = substr($pagebuff, $this->intmrk[$this->page]);

						$this->setPageBuffer($this->page, $pstart.$ccode."\n".$pend);

						$this->intmrk[$this->page] += strlen($ccode."\n");

					}

				}

			} else {

				$h = max($h, ($currentY - $y));

				// put cursor at the beginning of text

				$this->SetY($y); 

				$this->SetX($x);

				// design a cell around the text

				$ccode = $this->getCellCode($w, $h, '', $border, 1, '', $fill, '', 0, true);

				if ($border OR $fill) {

					if (end($this->transfmrk[$this->page]) !== false) {

						$pagemarkkey = key($this->transfmrk[$this->page]);

						$pagemark = &$this->transfmrk[$this->page][$pagemarkkey];

					} elseif ($this->InFooter) {

						$pagemark = &$this->footerpos[$this->page];

					} else {

						$pagemark = &$this->intmrk[$this->page];

					}

					$pagebuff = $this->getPageBuffer($this->page);

					$pstart = substr($pagebuff, 0, $pagemark);

					$pend = substr($pagebuff, $pagemark);

					$this->setPageBuffer($this->page, $pstart.$ccode."\n".$pend);

					$pagemark += strlen($ccode."\n");

				}

			}

			// Get end-of-cell Y position

			$currentY = $this->GetY();

			// restore original margin values

			$this->SetLeftMargin($lMargin);

			$this->SetRightMargin($rMargin);

			if ($ln > 0) {

				//Go to the beginning of the next line

				$this->SetY($currentY);

				if ($ln == 2) {

					$this->SetX($x + $w);

				}

			} else {

				// go left or right by case

				$this->setPage($startpage);

				$this->y = $y;

				$this->SetX($x + $w);

			}

			return $nl;

		}



		/**

		* Get the border mode accounting for multicell position (opens bottom side of multicell crossing pages)

		* @param mixed $border Indicates if borders must be drawn around the cell block. The value can be either a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul>or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul>

		* @param string multicell position: 'start', 'middle', 'end'

		* @return border mode

		* @access protected

		* @since 4.4.002 (2008-12-09)

		*/

		protected function getBorderMode($border, $position='start') {

			if ((!$this->opencell) AND ($border == 1)) {

				return 1;

			}

			$cborder = '';

			switch ($position) {

				case 'start': {

					if ($border == 1) {

						$cborder = 'LTR';

					} else {

						if (!(false === strpos($border, 'L'))) {

							$cborder .= 'L';

						}

						if (!(false === strpos($border, 'T'))) {

							$cborder .= 'T';

						}

						if (!(false === strpos($border, 'R'))) {

							$cborder .= 'R';

						}

						if ((!$this->opencell) AND (!(false === strpos($border, 'B')))) {

							$cborder .= 'B';

						}

					}

					break;

				}

				case 'middle': {

					if ($border == 1) {

						$cborder = 'LR';

					} else {

						if (!(false === strpos($border, 'L'))) {

							$cborder .= 'L';

						}

						if ((!$this->opencell) AND (!(false === strpos($border, 'T')))) {

							$cborder .= 'T';

						}

						if (!(false === strpos($border, 'R'))) {

							$cborder .= 'R';

						}

						if ((!$this->opencell) AND (!(false === strpos($border, 'B')))) {

							$cborder .= 'B';

						}

					}

					break;

				}

				case 'end': {

					if ($border == 1) {

						$cborder = 'LRB';

					} else {

						if (!(false === strpos($border, 'L'))) {

							$cborder .= 'L';

						}

						if ((!$this->opencell) AND (!(false === strpos($border, 'T')))) {

							$cborder .= 'T';

						}

						if (!(false === strpos($border, 'R'))) {

							$cborder .= 'R';

						}

						if (!(false === strpos($border, 'B'))) {

							$cborder .= 'B';

						}

					}

					break;

				}

				default: {

					$cborder = $border;

					break;

				}

			}

			return $cborder;

		}



		/**

		* This method returns the estimated number of lines required to print the text.

		* @param string $txt text to print

		* @param float $w width of cell. If 0, they extend up to the right margin of the page.

		* @return int Return the estimated number of lines.

		* @access public

		* @since 4.5.011

		*/

		public function getNumLines($txt, $w=0) {

			$lines = 0;

			if ($this->empty_string($w) OR ($w <= 0)) {

				if ($this->rtl) {

					$w = $this->x - $this->lMargin;

				} else {

					$w = $this->w - $this->rMargin - $this->x;

				}

			}

			// max column width

			$wmax = $w - (2 * $this->cMargin);

			// remove carriage returns

			$txt = str_replace("\r", '', $txt);

			// remove last newline (if any)

			if (substr($txt,-1) == "\n") {

				$txt = substr($txt, 0, -1);

			}

			// divide text in blocks

			$txtblocks = explode("\n", $txt);

			// for each block;

			foreach ($txtblocks as $block) {

				// estimate the number of lines

				$lines += $this->empty_string($block) ? 1 : (ceil($this->GetStringWidth($block) / $wmax));

			}

			return $lines;

		}

			

		/**

		* This method prints text from the current position.<br />

		* @param float $h Line height

		* @param string $txt String to print

		* @param mixed $link URL or identifier returned by AddLink()

		* @param int $fill Indicates if the background must be painted (1) or transparent (0). Default value: 0.

		* @param string $align Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>

		* @param boolean $ln if true set cursor at the bottom of the line, otherwise set cursor at the top of the line.

		* @param int $stretch stretch carachter mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if necessary</li><li>2 = forced horizontal scaling</li><li>3 = character spacing only if necessary</li><li>4 = forced character spacing</li></ul>

		* @param boolean $firstline if true prints only the first line and return the remaining string.

		* @param boolean $firstblock if true the string is the starting of a line.

		* @param float $maxh maximum height. The remaining unprinted text will be returned. It should be >= $h and less then remaining space to the bottom of the page, or 0 for disable this feature.

		* @return mixed Return the number of cells or the remaining string if $firstline = true.

		* @access public

		* @since 1.5

		*/

		public function Write($h, $txt, $link='', $fill=0, $align='', $ln=false, $stretch=0, $firstline=false, $firstblock=false, $maxh=0) {

			if (strlen($txt) == 0) {

				$txt = ' ';

			}

			// remove carriage returns

			$s = str_replace("\r", '', $txt);

			// check if string contains arabic text

			if (preg_match(K_RE_PATTERN_ARABIC, $s)) {

				$arabic = true;

			} else {

				$arabic = false;

			}

			// check if string contains RTL text

			if ($arabic OR $this->tmprtl OR preg_match(K_RE_PATTERN_RTL, $txt)) {

				$rtlmode = true;

			} else {

				$rtlmode = false;

			}

			// get a char width

			$chrwidth = $this->GetCharWidth('.');

			// get array of unicode values

			$chars = $this->UTF8StringToArray($s);

			// get array of chars

			$uchars = $this->UTF8ArrayToUniArray($chars);

			// get the number of characters

			$nb = count($chars);

			// replacement for SHY character (minus symbol)

			$shy_replacement = 45;

			$shy_replacement_char = $this->unichr($shy_replacement);

			// widht for SHY replacement

			$shy_replacement_width = $this->GetCharWidth($shy_replacement);

			// store current position

			$prevx = $this->x;

			$prevy = $this->y;

			// max Y

			$maxy = $this->y + $maxh - $h - (2 * $this->cMargin);

			// calculate remaining line width ($w)

			if ($this->rtl) {

				$w = $this->x - $this->lMargin;

			} else {

				$w = $this->w - $this->rMargin - $this->x;

			}

			// max column width

			$wmax = $w - (2 * $this->cMargin);

			$i = 0; // character position

			$j = 0; // current starting position

			$sep = -1; // position of the last blank space

			$shy = false; // true if the last blank is a soft hypen (SHY)

			$l = 0; // current string lenght

			$nl = 0; //number of lines

			$linebreak = false;

			// for each character

			while ($i < $nb) {

				if (($maxh > 0) AND ($this->y >= $maxy) ) {

					$firstline = true;

				}

				//Get the current character

				$c = $chars[$i];

				if ($c == 10) { // 10 = "\n" = new line

					//Explicit line break

					if ($align == 'J') {

						if ($this->rtl) {

							$talign = 'R';

						} else {

							$talign = 'L';

						}

					} else {

						$talign = $align;

					}

					$tmpstr = $this->UniArrSubString($uchars, $j, $i);

					if ($firstline) {

						$startx = $this->x;

						$tmparr = array_slice($chars, $j, $i);

						if ($rtlmode) {

							$tmparr = $this->utf8Bidi($tmparr, $tmpstr, $this->tmprtl);

						}

						$linew = $this->GetArrStringWidth($tmparr);

						unset($tmparr);

						if ($this->rtl) {

							$this->endlinex = $startx - $linew;

						} else {

							$this->endlinex = $startx + $linew;

						}

						$w = $linew;

						$tmpcmargin = $this->cMargin;

						if ($maxh == 0) {

							$this->cMargin = 0;

						}

					}

					$this->Cell($w, $h, $tmpstr, 0, 1, $talign, $fill, $link, $stretch);

					unset($tmpstr);

					if ($firstline) {

						$this->cMargin = $tmpcmargin;

						return ($this->UniArrSubString($uchars, $i));

					}

					++$nl;

					$j = $i + 1;

					$l = 0;

					$sep = -1;

					$shy = false;

					// account for margin changes

					if ((($this->y + $this->lasth) > $this->PageBreakTrigger) AND (!$this->InFooter)) {

						// AcceptPageBreak() may be overriden on extended classed to include margin changes

						$this->AcceptPageBreak();

					}

					$w = $this->getRemainingWidth();

					$wmax = $w - (2 * $this->cMargin);

				} else {

					// 160 is the non-breaking space.

					// 173 is SHY (Soft Hypen).

					// \p{Z} or \p{Separator}: any kind of Unicode whitespace or invisible separator.

					// \p{Lo} or \p{Other_Letter}: a Unicode letter or ideograph that does not have lowercase and uppercase variants.

					// \p{Lo} is needed because Chinese characters are packed next to each other without spaces in between.

					if (($c != 160) AND (($c == 173) OR preg_match($this->re_spaces, $this->unichr($c)))) {

						// update last blank space position

						$sep = $i;

						// check if is a SHY

						if ($c == 173) {

							$shy = true;

						} else {

							$shy = false;

						}

					}

					// update string length

					if ((($this->CurrentFont['type'] == 'TrueTypeUnicode') OR ($this->CurrentFont['type'] == 'cidfont0')) AND ($arabic)) {

						// with bidirectional algorithm some chars may be changed affecting the line length

						// *** very slow ***

						$l = $this->GetArrStringWidth($this->utf8Bidi(array_slice($chars, $j, $i-$j+1), '', $this->tmprtl));

					} else {

						$l += $this->GetCharWidth($c);

					}

					if (($l > $wmax) OR ($shy AND (($l + $shy_replacement_width) > $wmax)) ) {

						// we have reached the end of column

						if ($sep == -1) {

							// check if the line was already started

							if (($this->rtl AND ($this->x <= ($this->w - $this->rMargin - $chrwidth)))

								OR ((!$this->rtl) AND ($this->x >= ($this->lMargin + $chrwidth)))) {

								// print a void cell and go to next line

								$this->Cell($w, $h, '', 0, 1);

								$linebreak = true;

								if ($firstline) {

									return ($this->UniArrSubString($uchars, $j));

								}

							} else {

								// truncate the word becau