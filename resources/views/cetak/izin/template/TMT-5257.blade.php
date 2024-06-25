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

        .MsoChpDefault {
            font-family: "Cambria", serif;
        }

        /* Page Definitions */
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

        #watermark {
            position: fixed;
            top: 12%;
            width: 100%;
            text-align: center;
            opacity: .2;
            transform-origin: 50% 50%;
            z-index: -1000;
        }
        -->
    </style>

</head>

<body lang=EN-US link=blue vlink=purple style='word-wrap:break-word'>

    <div id="watermark">
        <img src="images/kepri.png" style="height: 830px" alt="" srcset="">
    </div>

    <div class=WordSection1>

        <p class=MsoNormal align=center style='text-align:center'><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'><img width=103 height=103 id="Picture 8" src="images/logo-portal-kepriprov.png"></span></p>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="100%" valign=top style='width:100.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center'><b><span style='font-family:"Times New Roman",serif'>PEMERINTAH PROVINSI KEPULAUAN
                                RIAU</span></b></p>
                </td>
            </tr>
            <tr>
                <td width="100%" valign=top style='width:100.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center'><b><span style='font-family:"Times New Roman",serif'>DINAS PENANAMAN MODAL DAN
                                PELAYANAN TERPADU SATU PINTU</span></b></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="100%" valign=top style='width:100.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center'><b><u><span style='font-family:"Times New Roman",serif'>PERSETUJUAN PENGOPERASIAN KAPAL
                                    ANGKUTAN PENYEBERANGAN SEMENTARA</span></u></b></p>
                </td>
            </tr>
            <tr>
                <td width="100%" valign=top style='width:100.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center'><b><span style='font-family:"Times New Roman",serif'>NOMOR {{$permohonan->perizinan->perizinan_configuration->prefix_nomor_izin}}{{$permohonan->perizinan->perizinan_configuration->nomor_izin}}{{$permohonan->perizinan->perizinan_configuration->suffix_nomor_izin}}</span></b></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="100%" valign=top style='width:100.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-family:
  "Times New Roman",serif'>Berdasarkan surat permohonan {{$permohonan->profile_usaha->nama_perusahaan}} Nomor : {{$permohonan->formulir['Nomor Surat Permohonan']}} tanggal {{ \Carbon\Carbon::parse($permohonan->formulir['Tanggal Surat Permohonan'])->isoFormat('D MMMM Y') }},
                            berdasarkan rekomendasi teknis dari Dinas Perhubungan Provinsi
                            Kepulauan Riau sesuai surat Nomor {{$permohonan->nomor_kajian_teknis}} Tanggal {{ \Carbon\Carbon::parse($permohonan->tanggal_kajian_teknis_terbit)->isoFormat('D MMMM Y') }},
                            bersama ini di berikan persetujuan pengoperasian kapal :</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="47%" valign=top style='width:47.64%;border:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><b><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>NAMA
                                KAPAL</span></b></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;border:solid windowtext 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>:</span></p>
                </td>
                <td width="49%" valign=top style='width:49.7%;border:solid windowtext 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.5pt;
  font-family:"Times New Roman",serif'>{{$permohonan->formulir['Nama Kapal']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="47%" valign=top style='width:47.64%;border:solid windowtext 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><b><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>PADA
                                LINTAS</span></b></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>:</span></p>
                </td>
                <td width="49%" valign=top style='width:49.7%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.5pt;
  font-family:"Times New Roman",serif'>{{$permohonan->formulir['Lintas']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="47%" valign=top style='width:47.64%;border:solid windowtext 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><b><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>NAMA
                                PERUSAHAAN</span></b></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>:</span></p>
                </td>
                <td width="49%" valign=top style='width:49.7%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.5pt;
  font-family:"Times New Roman",serif'>{{$permohonan->profile_usaha->nama_perusahaan}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="47%" valign=top style='width:47.64%;border:solid windowtext 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><b><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>ALAMAT
                                KANTOR</span></b></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>:</span></p>
                </td>
                <td width="49%" valign=top style='width:49.7%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.5pt;
  font-family:"Times New Roman",serif'>{{$permohonan->profile_usaha->alamat}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="47%" valign=top style='width:47.64%;border:solid windowtext 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><b><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>NAMA
                                PEMILIK/PENANGGUNG JAWAB</span></b></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>:</span></p>
                </td>
                <td width="49%" valign=top style='width:49.7%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.5pt;
  font-family:"Times New Roman",serif'>{{$permohonan->formulir['Nama Pemilik Kapal']}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="47%" valign=top style='width:47.64%;border:solid windowtext 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><b><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>NOMOR
                                POKOK WAJIB PAJAK (NPWP)</span></b></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>:</span></p>
                </td>
                <td width="49%" valign=top style='width:49.7%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.5pt;
  font-family:"Times New Roman",serif'>{{$permohonan->profile_usaha->npwp}}</span></p>
                </td>
            </tr>
            <tr>
                <td width="47%" valign=top style='width:47.64%;border:solid windowtext 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><b><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>NOMOR
                                IJIN USAHA ANGKUTAN PENYEBERANGAN (SIUAP)</span></b></p>
                </td>
                <td width="2%" valign=top style='width:2.66%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>:</span></p>
                </td>
                <td width="49%" valign=top style='width:49.7%;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.5pt;
  font-family:"Times New Roman",serif'>{{$permohonan->formulir['Nomor Izin Usaha Angkutan Penyeberangan (SIUAP)']}}</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="100%" valign=top style='width:100.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><b><span style='font-size:10.5pt;
  font-family:"Times New Roman",serif'>KEWAJIBAN PEMEGANG SURAT PERSETUJUAN
                                PENGOPERASIAN KAPAL ANGKUTAN PENYEBERANGAN :</span></b></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span style='font-size:5.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="3%" valign=top style='width:3.5%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Times New Roman",serif'>1.</span></p>
                </td>
                <td width="96%" valign=top style='width:96.5%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.0pt;
  font-family:"Times New Roman",serif'>Memiliki izin usahan yang sah;</span></p>
                </td>
            </tr>
            <tr>
                <td width="3%" valign=top style='width:3.5%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Times New Roman",serif'>2.</span></p>
                </td>
                <td width="96%" valign=top style='width:96.5%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.0pt;
  font-family:"Times New Roman",serif'>Menyelenggarakan pelayaran penyeberangan
                            menurut jadwal pelayaran, mengumumkan dan melaksanakan ketentuan tarif
                            angkutan penyeberangan yang ditetapkan;</span></p>
                </td>
            </tr>
            <tr>
                <td width="3%" valign=top style='width:3.5%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Times New Roman",serif'>3.</span></p>
                </td>
                <td width="96%" valign=top style='width:96.5%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.0pt;
  font-family:"Times New Roman",serif'>Mengoperasikan kapal motor penyeberangan
                            memenuhi persyaratan keselamatan pelayaran dan spesifikasi teknis lintas dan
                            pelabuhan penyeberangan yang bersangkutan serta menyediakan kapal pengganti,
                            apabila kapal tersebut tidak dapat beroperasi pada lintas penyeberangan yang
                            ditetapkan;</span></p>
                </td>
            </tr>
            <tr>
                <td width="3%" valign=top style='width:3.5%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Times New Roman",serif'>4.</span></p>
                </td>
                <td width="96%" valign=top style='width:96.5%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.0pt;
  font-family:"Times New Roman",serif'>Mematuhi penggunaan dermaga ataupun
                            tempat pendaratan lain yang ditetapkan oleh pihak-pihak lain yang berwenang;</span></p>
                </td>
            </tr>
            <tr>
                <td width="3%" valign=top style='width:3.5%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Times New Roman",serif'>5.</span></p>
                </td>
                <td width="96%" valign=top style='width:96.5%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.0pt;
  font-family:"Times New Roman",serif'>Menjamin keselamatan dan kelancaran naik
                            turunnya penumpang, barang, hewan, kendaraan dan muatan lainnya dan termasuk menyediakan
                            ruangan untuk pos;</span></p>
                </td>
            </tr>
            <tr>
                <td width="3%" valign=top style='width:3.5%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Times New Roman",serif'>6.</span></p>
                </td>
                <td width="96%" valign=top style='width:96.5%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.0pt;
  font-family:"Times New Roman",serif'>Menghindarkan segala sesuatu yang dapat
                            menyebakan pencemaran lingkungan;</span></p>
                </td>
            </tr>
            <tr>
                <td width="3%" valign=top style='width:3.5%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Times New Roman",serif'>7.</span></p>
                </td>
                <td width="96%" valign=top style='width:96.5%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.0pt;
  font-family:"Times New Roman",serif'>Melaporkan kegiatan operasional bulanan
                            dan tahunan kepada Gubernur Kepulauan Riau Cq. Kepala Dinas Perhubungan
                            dengan tembusan kepada Direktur Jenderal Perhubungan Darat;</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 style='border-collapse:collapse;border:none'>
            <tr>
                <td width=713 valign=top style='width:535.05pt;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span style='font-size:10.5pt;
  font-family:"Times New Roman",serif'>SURAT PERSETUJUAN PENGOPERASIAN KAPAL
                            ANGKUTAN PENYEBERANGAN INI DAPAT DITINJAU KEMBALI ATAU DICABUT, APABILA
                            PEMEGANG PERSETUJUAN TIDAK MEMATUHI KEWAJIBAN DALAM SURAT PERSETUJUAN
                            PENGOPERASIAN KAPAL PENYEBERANGAN INI DAN/ATAU MELAKUKAN TINDAK PIDANA YANG
                            BERSANGKUTAN DENGAN KEGIATANNYA.</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal style='text-align:justify'><span lang=id style='font-size:
9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="100%" valign=top style='width:100.0%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal style='text-align:justify'><span lang=id style='font-size:
  10.5pt;font-family:"Times New Roman",serif'>SURAT PERSETUJUAN PENGOPERASIAN
                            KAPAL ANGKUTAN PENYEBERANGAN INI BERLAKU 3 (TIGA)</span><span lang=id style='font-size:10.5pt;font-family:"Times New Roman",serif'> </span><span lang=id style='font-size:10.5pt;font-family:"Times New Roman",serif'>BULAN
                            SEJAK DITETAPKAN.</span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="100%" style='width:100.0%;border-collapse:collapse;border:none'>
            <tr>
                <td width="54%" valign=top style='width:54.26%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:10.5pt;font-family:"Times New Roman",serif'>&nbsp;</span></p>
                </td>
                <td width="13%" valign=top style='width:13.26%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>Ditetapkan
                            di</span></p>
                </td>
                <td width="2%" valign=top style='width:2.64%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>:</span></p>
                </td>
                <td width="29%" valign=top style='width:29.84%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>Tanjungpinang</span></p>
                </td>
            </tr>
            <tr>
                <td width="54%" valign=top style='width:54.26%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:10.5pt;font-family:"Times New Roman",serif'>&nbsp;</span></p>
                </td>
                <td width="13%" valign=top style='width:13.26%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>Pada
                            Tanggal</span></p>
                </td>
                <td width="2%" valign=top style='width:2.64%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>:</span></p>
                </td>
                <td width="29%" valign=top style='width:29.84%;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>{{ \Carbon\Carbon::parse($permohonan->tanggal_izin_terbit)->isoFormat('D MMMM Y') }}
                        </span></p>
                </td>
            </tr>
        </table>

        <p class=MsoNormal><span lang=id style='font-size:9.5pt;font-family:"Arial",sans-serif'>&nbsp;</span></p>

        <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 style='border-collapse:collapse;border:none'>
            <tr>
                <td width=340 valign=top style='width:254.9pt;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal><span lang=id style='font-size:10.5pt;font-family:"Times New Roman",serif'>&nbsp;</span></p>
                </td>
                <td width=374 valign=top style='width:280.15pt;padding:0in 5.4pt 0in 5.4pt'>
                    <p class=MsoNormal align=center style='text-align:center'><b><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>KEPALA DINAS
                                PENANAMAN MODAL DAN</span></b></p>
                    <p class=MsoNormal align=center style='text-align:center'><b><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>PELAYANAN
                                TERPADU SATU PINTU</span></b></p>
                    <p class=MsoNormal align=center style='text-align:center'><b><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>PROVINSI
                                KEPULAUAN RIAU,</span></b></p>
                    @if($permohonan->status_permohonan_id == 12)
                    <p class=MsoNormal align=center style='text-align:center'><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>
                            <img width=58 height=58 id="Picture 6" src="images/qrcodette.png">
                        </span></p>
                    @else
                    <p class=MsoNormal align=center style='text-align:center;padding:20px;'><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>[DRAFT]</span></p>
                    @endif
                    <p class=MsoNormal><b><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>                        
                                HASFARIZAL HANDRA, S.Sos</span></b></p>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>                        
                            Pembina Utama Madya</span></p>
                    <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Times New Roman",serif'>                        
                            NIP. 19690329 199003 1 009</span></p>
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