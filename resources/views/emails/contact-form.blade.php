<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رسالة جديدة — رونق النجوم</title>
</head>
<body style="margin:0;padding:0;background-color:#f8f8fa;font-family:'Segoe UI',Tahoma,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f8fa;padding:45px 15px;">
        <tr>
            <td align="center">
                <table width="580" cellpadding="0" cellspacing="0" style="max-width:580px;">

                    {{-- Logo Circle --}}
                    <tr>
                        <td align="center" style="padding-bottom:0;">
                            <table cellpadding="0" cellspacing="0" style="width:250px;height:250px;border-radius:50%;background:#ffffff;box-shadow:0 8px 24px rgba(0,0,0,0.10);margin-bottom:-125px;">
                                <tr>
                                    <td align="center" valign="middle" style="height:250px;padding:37px;">
                                        <img src="{{ $logoEmbedded }}" alt="رونق النجوم" style="width:100%;height:auto;display:block;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Header --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#f43f5e,#be123c);border-radius:20px 20px 0 0;padding:150px 35px 24px;text-align:center;">
                            <h1 style="color:#ffffff;font-size:28px;margin:0;font-weight:900;letter-spacing:0.5px;">رونق النجوم</h1>
                            <p style="color:#ffffff;font-size:13px;margin:4px 0 0;font-weight:400;letter-spacing:2px;">RAWNAQ AL NUJOOM</p>
                            <p style="color:#fecdd3;font-size:12px;margin:8px 0 0;font-weight:300;">HAIR, SKIN &amp; NAIL SERVICES</p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="background:linear-gradient(180deg,#ffffff,#fafafa);padding:32px 35px 10px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#fef2f2,#fff7ed);border-radius:16px;border:1px solid #fee2e2;padding:20px;margin-bottom:24px;">
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding-bottom:6px;">
                                                    <p style="color:#e11d48;font-size:13px;font-weight:700;margin:0;">المرسل</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px 0;border-top:1px solid #fee2e2;">
                                                    <table width="100%">
                                                        <tr>
                                                            <td style="color:#6b7280;font-size:13px;width:80px;padding-left:10px;">الاسم</td>
                                                            <td style="font-weight:700;color:#1f2937;font-size:15px;">{{ $data['name'] }}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px 0;border-top:1px solid #fee2e2;">
                                                    <table width="100%">
                                                        <tr>
                                                            <td style="color:#6b7280;font-size:13px;width:80px;padding-left:10px;">رقم الهاتف</td>
                                                            <td style="font-weight:600;color:#1f2937;font-size:14px;direction:ltr;unicode-bidi:embed;">+965 {{ $data['phone'] ?: '—' }}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:10px 0;border-top:1px solid #fee2e2;">
                                                    <table width="100%">
                                                        <tr>
                                                            <td style="color:#6b7280;font-size:13px;width:80px;padding-left:10px;">الإيميل</td>
                                                            <td style="font-weight:600;color:#1f2937;font-size:14px;direction:ltr;unicode-bidi:embed;">
                                                                <a href="mailto:{{ $data['email'] }}" style="color:#e11d48;text-decoration:none;font-weight:600;">{{ $data['email'] ?: '—' }}</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- Divider --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin:20px 0;">
                                <tr>
                                    <td style="height:1px;background:linear-gradient(to right,transparent,#e5e7eb,transparent);"></td>
                                </tr>
                            </table>

                            {{-- Message --}}
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding-bottom:10px;">
                                        <p style="color:#e11d48;font-size:13px;font-weight:700;margin:0;">محتوى الرسالة</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background:#f9fafb;border-radius:12px;padding:20px;">
                                        <div style="color:#374151;font-size:14px;line-height:1.9;white-space:pre-wrap;">{{ $data['message'] }}</div>
                                    </td>
                                </tr>
                            </table>

                            {{-- Divider --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin:20px 0;">
                                <tr>
                                    <td style="height:1px;background:linear-gradient(to right,transparent,#e5e7eb,transparent);"></td>
                                </tr>
                            </table>

                            {{-- Contact --}}
                            <p style="color:#6b7280;font-size:13px;text-align:center;margin:0 0 4px;line-height:1.9;">
                                للاستفسار يرجى الاتصال على
                                <strong style="direction:ltr;color:#1f2937;font-weight:700;unicode-bidi:embed;">+965 2471 5678</strong><br>
                                <a href="mailto:{{ config('mail.from.address') }}" style="color:#e11d48;text-decoration:none;font-weight:600;">{{ config('mail.from.address') }}</a>
                            </p>
                        </td>
                    </tr>

                    {{-- Services Footer --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#fef2f2,#fff7ed);padding:22px 35px;text-align:center;border-top:1px solid #fee2e2;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding-bottom:10px;">
                                        <p style="color:#e11d48;font-size:13px;font-weight:700;margin:0;">خدماتنا</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center" style="padding:4px 0;">
                                                    <span style="color:#e11d48;font-size:13px;">🌸</span>
                                                    <span style="color:#6b7280;font-size:12px;margin:0 4px;">خدمات الشعر:</span>
                                                    <span style="color:#1f2937;font-size:13px;font-weight:600;">صبغ، قص، تصفيف</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding:4px 0;">
                                                    <span style="color:#e11d48;font-size:13px;">🌸</span>
                                                    <span style="color:#6b7280;font-size:12px;margin:0 4px;">خدمات البشرة:</span>
                                                    <span style="color:#1f2937;font-size:13px;font-weight:600;">تنظيف، ترطيب، عناية</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding:4px 0;">
                                                    <span style="color:#e11d48;font-size:13px;">🌸</span>
                                                    <span style="color:#6b7280;font-size:12px;margin:0 4px;">خدمات الأظافر:</span>
                                                    <span style="color:#1f2937;font-size:13px;font-weight:600;">مانيكير، باديكير، فن</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background:#f9fafb;border-radius:0 0 20px 20px;padding:18px 35px;text-align:center;border-top:1px solid #f3f4f6;">
                            <p style="color:#9ca3af;font-size:11px;margin:0;line-height:1.7;">
                                رونق النجوم — صالون متخصص في التجميل والعناية<br>
                                هذا إيميل تلقائي، يرجى عدم الرد عليه
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
