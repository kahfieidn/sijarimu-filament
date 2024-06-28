<html>

<head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <meta name=Generator content="Microsoft Word 15 (filtered)">
    <style>
        <!--
        /* Font Definitions */
        @font-face {
            font-family: Wingdings;
            panose-1: 5 0 0 0 0 0 0 0 0 0;
        }

        @font-face {
            font-family: "Cambria Math";
            panose-1: 2 4 5 3 5 4 6 3 2 4;
        }

        @font-face {
            font-family: Cambria;
            panose-1: 2 4 5 3 5 4 6 3 2 4;
        }

        @font-face {
            font-family: Georgia;
            panose-1: 2 4 5 2 5 4 5 2 3 3;
        }

        @font-face {
            font-family: "Arial MT";
        }

        /* Style Definitions */
        p.MsoNormal,
        li.MsoNormal,
        div.MsoNormal {
            margin: 0in;
            font-size: 11.0pt;
            font-family: "Cambria", serif;
        }

        p.MsoListParagraph,
        li.MsoListParagraph,
        div.MsoListParagraph {
            margin-top: 1.7pt;
            margin-right: 0in;
            margin-bottom: 0in;
            margin-left: 20.75pt;
            text-indent: -14.2pt;
            font-size: 11.0pt;
            font-family: "Cambria", serif;
        }

        .MsoChpDefault {
            font-family: "Cambria", serif;
        }

        @page WordSection1 {
            size: 609.55pt 935.55pt;
            margin: 14.2pt 45.65pt 14.45pt 28.35pt;
        }

        div.WordSection1 {
            page: WordSection1;
        }

        /* List Definitions */
        ol {
            margin-bottom: 0in;
        }

        ul {
            margin-bottom: 0in;
        }
        -->
    </style>

</head>

<body lang=EN-US link=blue vlink=purple style='word-wrap:break-word'>

    <div class=WordSection1>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'><img width=717 height=131 id=image2.png src="images/headercop.png"></span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="52%" valign=top style='width:52.94%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="47%" valign=top style='width:47.06%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal align=right style='text-align:right'><span lang=id style='font-family:"Arial",sans-serif'>Tanjungpinang, @if($permohonan->formulir['Tanggal Terbit Rekomendasi'] != null){{ \Carbon\Carbon::parse($permohonan->formulir['Tanggal Terbit Rekomendasi'])->isoFormat('D MMMM Y') }}@else [DRAFT]@endif</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:5.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="10%" valign=top style='width:10.6%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-family:"Arial",sans-serif'>Nomor</span></p>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>Lampiran</span></p>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>Sifat</span></p>
                    <p class=MsoNormal><span lang=id style='font-family:"Arial",sans-serif'>Hal</span></p>
                </td>
                <td width="2%" valign=top style='width:2.6%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>:</span></p>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>:</span></p>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>:</span></p>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="41%" valign=top style='width:41.08%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif'>{{$permohonan->perizinan->perizinan_configuration->prefix_nomor_rekomendasi}}{{$permohonan->perizinan->perizinan_configuration->nomor_rekomendasi}}{{$permohonan->perizinan->perizinan_configuration->suffix_nomor_rekomendasi}}</span></p>
                    <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif'>1
                            (satu) Berkas</span></p>
                    <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif'>Penting</span></p>
                    <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif'>Mohon
                            Rekomendasi Teknis </span></p>
                    <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif'>Rencana Pengoperasian Kapal (RPK) </span></p>
                    <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif'>{{$permohonan->formulir['Nama Kapal']}}</span></p>
                </td>
                <td width="15%" valign=top style='width:15.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal align=right style='text-align:right'><b><span lang=id style='font-family:"Arial",sans-serif'>&nbsp;</span></b></p>
                    <p class=MsoNormal align=right style='text-align:right'><b><span style='font-family:"Arial",sans-serif'>Yth.</span></b></p>
                </td>
                <td width="29%" valign=top style='width:29.84%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-family:
  "Arial",sans-serif'>Kepada</span></p>
                    <p class=MsoNormal style='text-align:justify'><b><span style='font-family:
  "Arial",sans-serif'>Dinas Perhubungan </span></b></p>
                    <p class=MsoNormal style='text-align:justify'><b><span style='font-family:
  "Arial",sans-serif'>Provinsi Kepulauan Riau</span></b></p>
                    <p class=MsoNormal><span lang=id style='font-family:"Arial",sans-serif'>di – </span></p>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>       <b>TANJUNGPINANG</b></span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="88%" valign=top style='width:80.12%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif'>Dengan
                            Hormat,</span></p>
                    <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif'>Menindaklanjuti
                            Surat Direktur {{$permohonan->profile_usaha->nama_perusahaan}} Nomor @if($permohonan->formulir['Nomor Surat Permohonan'] != null){{$permohonan->formulir['Nomor Surat Permohonan']}}@else [DRAFT]@endif perihal Penerbitan Rencana Pengoperasian Kapal Pelra pada Trayek Tetap dan
                            Teratur Angkutan Laut Dalam Negeri, bersama ini kami sampaikan hal-hal
                            sebagai berikut:</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:10.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="3%" valign=top style='width:3.96%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>1.</span></p>
                </td>
                <td width="84%" valign=top style='width:84.16%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-family:
  "Arial",sans-serif'>Persetujuan Pengoperasian Kapal Pelra Perusahaan yang
                            bersangkutan </span><span style='font-family:"Arial",sans-serif'>mengajukan
                            permohonan baru </span><span lang=id style='font-family:"Arial",sans-serif'>untuk
                        </span><span style='font-family:"Arial",sans-serif'>izin Rencana
                            Pengoperasian Kapal (RPK), dengan data permohonan sebagai berikut</span><span lang=id style='font-family:"Arial",sans-serif'> :</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:7.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="15%" valign=top style='width:15.84%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="4%" valign=top style='width:4.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>a.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>Nama Perusahaan</span></p>
                </td>
                <td width="3%" valign=top style='width:3.1%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="44%" valign=top style='width:44.4%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif'>{{$permohonan->profile_usaha->nama_perusahaan}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="15%" valign=top style='width:15.84%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="4%" valign=top style='width:4.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>b.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>Nama Kapal</span></p>
                </td>
                <td width="3%" valign=top style='width:3.1%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="44%" valign=top style='width:44.4%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif'>{{$permohonan->formulir['Nama Kapal']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="15%" valign=top style='width:15.84%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="4%" valign=top style='width:4.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>c.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>Type Kapal</span></p>
                </td>
                <td width="3%" valign=top style='width:3.1%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="44%" valign=top style='width:44.4%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif'>{{$permohonan->formulir['Jenis Kapal']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="15%" valign=top style='width:15.84%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="4%" valign=top style='width:4.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>d.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>Pelabuhan
                            Pangkal</span></p>
                </td>
                <td width="3%" valign=top style='width:3.1%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="44%" valign=top style='width:44.4%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif'>{{$permohonan->formulir['Pelabuhan Pangkal']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="15%" valign=top style='width:15.84%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="4%" valign=top style='width:4.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>e.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>Route Trayek</span></p>
                </td>
                <td width="3%" valign=top style='width:3.1%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="44%" valign=top style='width:44.4%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-family:"Arial",sans-serif'>{{$permohonan->formulir['Route Trayek']}}</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="3%" valign=top style='width:3.96%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center'><span style='font-family:"Arial",sans-serif'>2.</span></p>
                </td>
                <td width="84%" valign=top style='width:84.16%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-family:
  "Arial",sans-serif'>Mengingat rencana kegiatan termasuk dalam sektor
                            Perhubungan, kiranya dapat ditindaklanjuti dengan Rekomendasi Teknis guna
                            mengetahui layak atau tidak diterbitkan sebagaimana yang dimohonkan, termasuk
                            kewajiban-kewajiban yang harus dilaksanakan oleh pemohon sesuai dengan
                            peraturan yang berlaku.</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="15%" valign=top style='width:15.84%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="84%" valign=top style='width:84.16%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-family:
  "Arial",sans-serif'>Demikian disampaikan untuk dimaklumi, atas perhatian dan
                            kerjasamanya diucapkan </span><span style='font-family:"Arial",sans-serif'>   </span><span lang=id style='font-family:"Arial",sans-serif'>terima kasih.</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <p class=MsoNormal><span lang=id style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="47%" valign=top style='width:47.64%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="52%" valign=top style='width:52.36%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center'><span style='position:absolute;z-index:251659264;left:0px;margin-left:486px;
  margin-top:12px;width:91px;height:124px'>
                            @if(in_array($permohonan->status_permohonan_id, [7,8,9,10,11,12]))
                            <img width=91 height=124 src="images/ttdalfian.png">
                            @endif
                        </span><b><span lang=IN style='font-family:"Arial",sans-serif'>a.n. KEPALA DINAS</span></b><b><span lang=FI style='font-family:"Arial",sans-serif'> PENANAMAN MODAL DAN</span></b></p>
                    <p class=MsoNormal align=center style='text-align:center'><b><span lang=FI style='font-family:"Arial",sans-serif'>PELAYANAN TERPADU SATU PINTU</span></b></p>
                    <p class=MsoNormal align=center style='text-align:center'><b><span lang=FI style='font-family:"Arial",sans-serif'>PROVINSI KEPULAUAN RIAU</span></b></p>
                    <p class=MsoNormal align=center style='text-align:center'><span lang=id style='font-family:"Arial",sans-serif'>Penata</span><span lang=IN style='font-family:"Arial",sans-serif'> Perizinan</span><span lang=id style='font-family:"Arial",sans-serif'> Ahli Madya</span><span lang=IN style='font-family:"Arial",sans-serif'>,</span></p>
                    <p class=MsoNormal align=center style='text-align:center'><span lang=IN style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
                    <p class=MsoNormal align=center style='text-align:center'><span lang=id style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
                    <p class=MsoNormal align=center style='text-align:center'><span lang=id style='font-family:"Arial",sans-serif'>&nbsp;</span></p>
                    <p class=MsoNormal><b><span style='font-family:"Arial",sans-serif'>                       
                            </span></b><b><span lang=IN style='font-family:"Arial",sans-serif'>ALFIAN,
                                S.Sos., M.Si</span></b></p>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>                       
                        </span><span lang=IN style='font-family:"Arial",sans-serif'>Pembina Tk. I
                            (IV/b)</span></p>
                    <p class=MsoNormal><span style='font-family:"Arial",sans-serif'>                       
                        </span><span lang=IN style='font-family:"Arial",sans-serif'>NIP. 19700713
                            199201 1 001</span></p>
                    <p class=MsoNormal align=right style='text-align:right'><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:5.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <p class=MsoNormal><span lang=id style='font-size:5.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="100%" valign=top style='width:100.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><b><span lang=id style='font-family:"Arial",sans-serif'>TEMBUSAN</span></b><span lang=id style='font-family:"Arial",sans-serif'>, disampaikan kepada Yth.:</span></p>
                    <p class=MsoListParagraph style='margin-left:.5in;text-indent:-.25in'><span lang=id style='font-family:"Arial",sans-serif'>-<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </span></span><span lang=id style='font-family:"Arial",sans-serif'>Kepala
                            Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu </span></p>
                    <p class=MsoListParagraph style='margin-left:.5in;text-indent:-.25in'><span lang=id style='font-family:"Arial",sans-serif'>-<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </span></span><span lang=id style='font-family:"Arial",sans-serif'>Provinsi
                            Kepulauan Riau di Tanjungpinang (sebagai laporan).</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

    </div>

</body>

</html>