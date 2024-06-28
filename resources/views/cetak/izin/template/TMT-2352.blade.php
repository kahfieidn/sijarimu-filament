<html>

<head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <meta name=Generator content="Microsoft Word 15 (filtered)">
    <style>
        <!--
        /* Font Definitions */
        @font-face {
            font-family: "Cambria Math";
            panose-1: 2 4 5 3 5 4 6 3 2 4;
        }

        @font-face {
            font-family: Georgia;
            panose-1: 2 4 5 2 5 4 5 2 3 3;
        }

        @font-face {
            font-family: Cambria;
            panose-1: 2 4 5 3 5 4 6 3 2 4;
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

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'><img width=720 height=131 id=image2.png src="images/headercop.png"></span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="52%" valign=top style='width:52.94%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="47%" valign=top style='width:47.06%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal align=right style='text-align:right'><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Tanjungpinang, @if(isset($permohonan->formulir['Tanggal Izin']) && $permohonan->formulir['Tanggal Izin'] != null)
                            {{ \Carbon\Carbon::parse($permohonan->formulir['Tanggal Izin'])->isoFormat('D MMMM Y') }}
                            @else
                            [DRAFT]
                            @endif</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:3.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="9%" valign=top style='width:9.42%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Nomor</span></p>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Sifat</span></p>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Lampiran</span></p>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Hal</span></p>
                </td>
                <td width="2%" valign=top style='width:2.52%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>:</span></p>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>:</span></p>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>:</span></p>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="38%" valign=top style='width:38.36%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>{{$permohonan->perizinan->perizinan_configuration->prefix_nomor_izin}}{{$permohonan->perizinan->perizinan_configuration->nomor_izin}}{{$permohonan->perizinan->perizinan_configuration->suffix_nomor_izin}}</span></p>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>-</span></p>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>-</span></p>
                    <p class=MsoNormal style='text-align:justify;'><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Persetujuan
                            Rencana Pengoperasian Kapal pada Trayek Tetap dan Teratur Angkutan Laut Dalam Negeri</span></p>
                </td>
                <td width="13%" valign=top style='width:13.24%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal align=right style='text-align:right'><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                    <p class=MsoNormal align=right style='text-align:right'><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>Yth.</span></p>
                </td>
                <td width="36%" valign=top style='width:36.46%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-size:
  9.5pt;font-family:"Arial",sans-serif'>Kepada</span></p>
                    <p class=MsoNormal style='text-align:justify'><b><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Pimpinan {{$permohonan->profile_usaha->nama_perusahaan}} </span></b></p>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-size:
  9.5pt;font-family:"Arial",sans-serif'>{{$permohonan->profile_usaha->alamat}}, {{$permohonan->profile_usaha->domisili}}, {{$permohonan->profile_usaha->provinsi}}</span></p>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>di
                            – </span></p>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>      
                        </span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Tempat</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="88%" valign=top style='width:88.12%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:9.5pt;
  font-family:"Arial",sans-serif'>         </span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Sesuai dengan
                            Undang-undang No. 17 Tahun 2008 Tentang Pelayaran, Peraturan Menteri</span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'> </span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Perhubungan
                            Nomor PM. 74 Tahun 2016 Tentang Perubahan Atas Peraturan Menteri Perhubungan
                            Nomor PM.93 Tahun 2013 tentang Penyelenggaraan dan Pengusahaan Angkutan Laut
                            dan menunjuk surat {{$permohonan->profile_usaha->nama_perusahaan}} Nomor {{$permohonan->formulir['Nomor Surat Permohonan']}}
                            tanggal @if(isset($permohonan->formulir['Tanggal Surat Permohonan']))
                            {{ \Carbon\Carbon::parse($permohonan->formulir['Tanggal Surat Permohonan'])->isoFormat('D MMMM Y') }}@else[DRAFT]@endif, berdasarkan rekomendasi teknis dari</span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'> </span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Dinas
                            Perhubungan Provinsi Kepulauan Riau sesuai surat Nomor {{$permohonan->nomor_kajian_teknis}}
                            Tanggal {{ \Carbon\Carbon::parse($permohonan->tanggal_kajian_teknis)->isoFormat('D MMMM Y') }}, dengan ini disampaikan bahwa kapal Saudara telah dicatat sebagai armada
                            pelayaran rakyat dan</span><span lang=id style='font-size:9.5pt;font-family:
  "Arial",sans-serif'> </span><span lang=id style='font-size:9.5pt;font-family:
  "Arial",sans-serif'>dioperasikan pada trayek tetap dan teratur
                            dengan data kapal sebagai berikut :</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:4.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>a.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.34%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>Nama
                            Kapal</span></p>
                </td>
                <td width="3%" valign=top style='width:3.12%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="50%" valign=top style='width:50.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:9.5pt;
  font-family:"Arial",sans-serif'>{{$permohonan->formulir['Nama Kapal']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>b.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.34%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>Type</span></p>
                </td>
                <td width="3%" valign=top style='width:3.12%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="50%" valign=top style='width:50.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:9.5pt;
  font-family:"Arial",sans-serif'>{{$permohonan->formulir['Jenis Kapal']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>c.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.34%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>Isi
                            Kotor GT/Bobot Mati (DWT)</span></p>
                </td>
                <td width="3%" valign=top style='width:3.12%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="50%" valign=top style='width:50.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:9.5pt;
  font-family:"Arial",sans-serif'>{{$permohonan->formulir['Isi Kotor/Bobot Mati']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>d.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.34%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>Tenaga
                            Penggerak (HP)</span></p>
                </td>
                <td width="3%" valign=top style='width:3.12%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="50%" valign=top style='width:50.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:9.5pt;
  font-family:"Arial",sans-serif'>{{$permohonan->formulir['Tenaga Penggerak']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>e.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.34%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>Kapasitas
                            Angkut</span></p>
                </td>
                <td width="3%" valign=top style='width:3.12%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="50%" valign=top style='width:50.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:9.5pt;
  font-family:"Arial",sans-serif'>{{$permohonan->formulir['Kapasitas Angkut']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>f.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.34%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>Status
                            Kepemilikan Kapal</span></p>
                </td>
                <td width="3%" valign=top style='width:3.12%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="50%" valign=top style='width:50.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:9.5pt;
  font-family:"Arial",sans-serif'>{{$permohonan->formulir['Status Kepemilikan Kapal']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>g.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.34%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>Pelabuhan
                            Pangkal</span></p>
                </td>
                <td width="3%" valign=top style='width:3.12%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="50%" valign=top style='width:50.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:9.5pt;
  font-family:"Arial",sans-serif'>{{$permohonan->formulir['Status Kepemilikan Kapal']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>h.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.34%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>Route
                            Trayek</span></p>
                </td>
                <td width="3%" valign=top style='width:3.12%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="50%" valign=top style='width:50.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:9.5pt;
  font-family:"Arial",sans-serif'>{{$permohonan->formulir['Route Trayek']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>i.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.34%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>Urgensi</span></p>
                </td>
                <td width="3%" valign=top style='width:3.12%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="50%" valign=top style='width:50.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:9.5pt;
  font-family:"Arial",sans-serif'>{{$permohonan->formulir['Urgensi']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>j.</span></p>
                </td>
                <td width="32%" valign=top style='width:32.34%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>Nomor
                            dan Tanggal SIUPPER</span></p>
                </td>
                <td width="3%" valign=top style='width:3.12%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>:</span></p>
                </td>
                <td width="50%" valign=top style='width:50.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:9.5pt;
  font-family:"Arial",sans-serif'>{{$permohonan->formulir['Nomor SIUPPER']}}, Tanggal {{ \Carbon\Carbon::parse($permohonan->formulir['Tanggal SIUPPER'])->isoFormat('D MMMM Y') }}</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="88%" valign=top style='width:88.12%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='text-align:justify;font-size:9.5pt;font-family:"Arial",sans-serif'>Pengoperasian
                            Kapal Pelra pada Trayek Tetap dan Teratur ini berlaku pada tanggal @if(isset($permohonan->formulir['Tanggal Izin']) && $permohonan->formulir['Tanggal Izin'] != null)
                            {{ \Carbon\Carbon::parse($permohonan->formulir['Tanggal Izin'])->isoFormat('D MMMM Y') }}
                            @else
                            [DRAFT]
                            @endif sampai dengan @if(isset($permohonan->formulir['Tanggal Expire Izin']) && $permohonan->formulir['Tanggal Expire Izin'] != null)
                            {{ \Carbon\Carbon::parse($permohonan->formulir['Tanggal Expire Izin'])->isoFormat('D MMMM Y') }}
                            @else
                            [DRAFT]
                            @endif, selain itu Saudara wajib
                            memperhatikan :</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:4.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>a.</span></p>
                </td>
                <td width="85%" valign=top style='width:85.46%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-size:
  9.5pt;font-family:"Arial",sans-serif'>Seluruh peraturan perundang-undangan yang berlaku dibidang angkutan di perairan, kepelabuhanan,
                            keselamatan dan keamanan pelayaran dan perlindungan maritim serta peraturan perundang-undangan
                            lainnya yang berlaku;</p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>b.</span></p>
                </td>
                <td width="85%" valign=top style='width:85.46%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-size:
  9.5pt;font-family:"Arial",sans-serif'>Laporan realisasi perjalanan kapal
                            (Voyage report) per triwulan;</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>c.</span></p>
                </td>
                <td width="85%" valign=top style='width:85.46%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-size:
  9.5pt;font-family:"Arial",sans-serif'>Dinas Penanaman Modal dan Pelayanan
                            Terpadu Satu Pintu Provinsi Kepulauan Riau Tidak Bertanggung</span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'> </span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Jawab terhadap
                            Perjanjian Pengangkutan yang dibuat Pemilik Barang dengan Pengangkut;</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>d.</span></p>
                </td>
                <td width="85%" valign=top style='width:85.46%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-size:
  9.5pt;font-family:"Arial",sans-serif'>Kebenaran laporan kegiatan operasional
                            yang disampaikan kepada Dinas Perhubungan Provinsi Kepulauan</span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'> </span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Riau;</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>e.</span></p>
                </td>
                <td width="85%" valign=top style='width:85.46%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-size:
  9.5pt;font-family:"Arial",sans-serif'>Penyalahgunaan RPK tidak menjadi
                            tanggungjawab Dinas Penanaman Modal dan Pelayanan Terpadu Satu</span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'> </span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Pintu Provinsi
                            Kepulauan Riau;</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>f.</span></p>
                </td>
                <td width="85%" valign=top style='width:85.46%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-size:
  9.5pt;font-family:"Arial",sans-serif'>Dinas Penanaman Modal dan Pelayanan
                            Terpadu Satu Pintu Provinsi Kepulauan Riau dapat membekukan</span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'> </span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>dan/atau
                            mencabut RPK yang diterbitkan apabila operator kapal menyalahi aturan dan
                            perundangundangan yang berlaku;</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>g.</span></p>
                </td>
                <td width="85%" valign=top style='width:85.46%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-size:
  9.5pt;font-family:"Arial",sans-serif'>Setiap operator kapal berkewajiban
                            untuk menciptakan situasi yang aman dan kondusif dalam beroperasi;</span></p>
                </td>
            </tr>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>h.</span></p>
                </td>
                <td width="85%" valign=top style='width:85.46%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-size:
  9.5pt;font-family:"Arial",sans-serif'>Apabila dikemudian hari ternyata
                            terdapat kekeliruan dalam penerbitan izin ini, Dinas Penanaman Modal</span></p>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-size:
  9.5pt;font-family:"Arial",sans-serif'>dan Pelayanan Terpadu Satu Pintu
                            Provinsi Kepulauan Riau dapat membatalkan perizinan ini.</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:5.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="11%" valign=top style='width:11.88%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>
                <td width="88%" valign=top style='width:88.12%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Demikian
                            disampaikan, untuk dapat dipergunakan sebagaimana mestinya.</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:10.0pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="66%" valign=top style='width:66.2%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>
                </td>

                <td width="33%" valign=top style='width:33.8%;padding:0in 5.4pt 0in 5.4pt'>
                    @if($permohonan->status_permohonan_id == 12)
                    <p class=MsoNormal align=right style='text-align:right'><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'><img width=223 height=80 id="Picture 2" src="images/ttekadis.jpg"></span></p>
                    @else
                    [DRAFT]
                    @endif

                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:5.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="100%" valign=top style='width:100.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>Tembusan
                            Yth:</span></p>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>1.
                            Kepala Dinas Perhubungan Provinsi Kepulauan Riau;</span></p>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>2.
                            Kepala Kantor Kesyahbandaran dan Otoritas Setempat;</span></p>
                    <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>3.
                            Kepala Kantor Unit Penyelenggara Pelabuhan Setempat.</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="100%" valign=top style='width:100.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-size:
  9.5pt;font-family:"Arial",sans-serif'>Sesuai dengan Peraturan dan
                            Perundang-Undangan yang berlaku bahwa dokumen ini telah ditandatangani secara
                            elektronik</span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>
                        </span><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>yang
                            telah diterbitkan oleh Balai Sertifikat Elektronik (BsrE)</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

    </div>

</body>

</html>