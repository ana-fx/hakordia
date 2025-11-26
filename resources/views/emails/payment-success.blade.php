<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Dikonfirmasi - Hakordia Fun Night Run</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f5f5f5; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); padding: 40px 40px 30px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="80" style="vertical-align: top; padding-right: 20px;">
                                        <img src="https://www.hakordia.online/images/logo.jpg" alt="Hakordia Logo" style="max-width: 80px; height: auto; display: block; border-radius: 4px;">
                                    </td>
                                    <td style="vertical-align: top;">
                                        <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 700; letter-spacing: -0.5px;">Hakordia Fun Night Run</h1>
                                        <p style="color: #cbd5e1; margin: 8px 0 0 0; font-size: 14px;">Pembayaran Dikonfirmasi</p>
                                    </td>
                                    <td align="right" style="vertical-align: top;">
                                        <div style="background-color: rgba(255,255,255,0.2); padding: 12px 20px; border-radius: 6px; display: inline-block;">
                                            <span style="color: #ffffff; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">PAID</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Invoice Info -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #ffffff; border-bottom: 1px solid #e5e7eb;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="50%" style="vertical-align: top;">
                                        <p style="margin: 0 0 8px 0; color: #6b7280; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Invoice Number</p>
                                        <p style="margin: 0; color: #111827; font-size: 18px; font-weight: 700;">{{ $orderNumber }}</p>
                                    </td>
                                    <td width="50%" align="right" style="vertical-align: top;">
                                        <p style="margin: 0 0 8px 0; color: #6b7280; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Tanggal Konfirmasi</p>
                                        <p style="margin: 0; color: #111827; font-size: 16px; font-weight: 600;">{{ $paidAt }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- From/To Section -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #ffffff; border-bottom: 1px solid #e5e7eb;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="50%" style="vertical-align: top; padding-right: 20px;">
                                        <p style="margin: 0 0 12px 0; color: #6b7280; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Dari</p>
                                        <p style="margin: 0 0 4px 0; color: #111827; font-size: 14px; font-weight: 700;">Hakordia Fun Night Run</p>
                                        <p style="margin: 0; color: #6b7280; font-size: 13px;">Jember, Indonesia</p>
                                    </td>
                                    <td width="50%" style="vertical-align: top; padding-left: 20px;">
                                        <p style="margin: 0 0 12px 0; color: #6b7280; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Kepada</p>
                                        <p style="margin: 0 0 4px 0; color: #111827; font-size: 14px; font-weight: 700;">Peserta Terdaftar</p>
                                        <p style="margin: 0; color: #6b7280; font-size: 13px;">Pembayaran Anda telah dikonfirmasi</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Items Table -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #ffffff;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <thead>
                                    <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                                        <th align="left" style="padding: 12px 0; color: #6b7280; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Deskripsi</th>
                                        <th align="right" style="padding: 12px 0; color: #6b7280; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 16px 0; border-bottom: 1px solid #e5e7eb; color: #111827; font-size: 14px;">
                                            <strong>Pendaftaran Hakordia Fun Night Run</strong><br>
                                            @if(isset($ticketName) && $ticketName)
                                                <span style="color: #6b7280; font-size: 13px;">Tiket: {{ $ticketName }}</span><br>
                                            @endif
                                            <span style="color: #6b7280; font-size: 13px;">{{ $orderNumber }}</span>
                                        </td>
                                        <td align="right" style="padding: 16px 0; border-bottom: 1px solid #e5e7eb; color: #111827; font-size: 14px; font-weight: 600;">
                                            Rp {{ number_format($totalAmount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <!-- Total Section -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px; background-color: #ffffff;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="right" style="padding-top: 20px;">
                                        <table cellpadding="0" cellspacing="0" style="width: 250px; margin-left: auto;">
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Subtotal</td>
                                                <td align="right" style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600;">Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px;">Pajak</td>
                                                <td align="right" style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600;">Rp 0</td>
                                            </tr>
                                            <tr style="border-top: 2px solid #e5e7eb; margin-top: 8px;">
                                                <td style="padding: 16px 0 8px 0; color: #111827; font-size: 16px; font-weight: 700;">Total</td>
                                                <td align="right" style="padding: 16px 0 8px 0; color: #111827; font-size: 20px; font-weight: 700;">Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Success Message Section -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #f9fafb; border-top: 1px solid #e5e7eb;">
                            <div style="background-color: #d1fae5; padding: 20px; border-radius: 6px; border-left: 4px solid #10b981;">
                                <p style="margin: 0 0 12px 0; color: #065f46; font-size: 14px; font-weight: 600;">✓ Pembayaran Berhasil Dikonfirmasi</p>
                                <p style="margin: 0; color: #047857; font-size: 13px; line-height: 1.6;">
                                    Terima kasih! Pembayaran Anda telah dikonfirmasi dan pendaftaran Anda aktif. Silakan simpan email ini sebagai bukti pembayaran.
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- Action Button -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px; background-color: #ffffff; text-align: center;">
                            <a href="{{ $checkoutUrl }}" style="display: inline-block; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; padding: 14px 32px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);">
                                Lihat Detail Order
                            </a>
                        </td>
                    </tr>

                    <!-- Message Section -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px; background-color: #ffffff;">
                            <div style="background-color: #fef3c7; padding: 20px; border-radius: 6px; border-left: 4px solid #f59e0b;">
                                <p style="margin: 0 0 12px 0; color: #111827; font-size: 14px; font-weight: 600;">Catatan Penting</p>
                                <p style="margin: 0 0 8px 0; color: #92400e; font-size: 13px; line-height: 1.6;">
                                    Pastikan data yang terdaftar sudah benar. Bawa identitas asli saat Race Pack Pickup pada tanggal 5 Desember 2025. Untuk pertanyaan, hubungi admin.
                                </p>
                                <p style="margin: 12px 0 0 0; color: #92400e; font-size: 13px;">
                                    <strong>Pertanyaan?</strong> Hubungi admin:<br>
                                    <a href="https://wa.me/6285183360304" style="color: #3b82f6; text-decoration: none;">+62 851-8336-0304</a> atau
                                    <a href="https://wa.me/6282139939685" style="color: #3b82f6; text-decoration: none;">+62 821-3993-9685</a>
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #f9fafb; border-top: 1px solid #e5e7eb; text-align: center;">
                            <p style="margin: 0; color: #6b7280; font-size: 12px;">
                                &copy; {{ date('Y') }} Hakordia Fun Night Run. All rights reserved.
                            </p>
                            <p style="margin: 8px 0 0 0; color: #9ca3af; font-size: 11px;">
                                Email ini dikirim otomatis, mohon tidak membalas email ini.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
