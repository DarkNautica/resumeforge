<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $application->tailored_resume['full_name'] ?? 'Resume' }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Times New Roman', 'Times', serif; background: #ffffff; color: #000000;">

@php
    $tr = $application->tailored_resume;
@endphp

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- CLASSIC — Centered serif, ATS-friendly, black & white only          --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; border-collapse: collapse;">
    <tr>
        <td valign="top" style="padding: 54px 64px; vertical-align: top;">

            {{-- ── Centered header ── --}}
            <div style="text-align: center;">
                <div style="font-size: 26px; font-weight: bold; color: #000000; line-height: 1.15; letter-spacing: 1px;">
                    {{ strtoupper($tr['full_name'] ?? '') }}
                </div>
                <div style="font-size: 11px; color: #000000; margin-top: 8px; line-height: 1.5;">
                    @php
                        $contactBits = array_filter([$tr['email'] ?? null, $tr['phone'] ?? null, $tr['location'] ?? null]);
                    @endphp
                    {!! implode(' &nbsp;&middot;&nbsp; ', array_map('e', $contactBits)) !!}
                </div>
            </div>

            {{-- Horizontal rule --}}
            <div style="border-top: 1px solid #000000; margin-top: 16px; margin-bottom: 18px; height: 0; font-size: 0;">&nbsp;</div>

            {{-- Summary --}}
            @if (!empty($tr['summary']))
                <div style="font-size: 11px; font-weight: bold; color: #000000; text-transform: uppercase; letter-spacing: 1.5px; text-align: center; margin-bottom: 8px;">Summary</div>
                <div style="font-size: 11px; line-height: 1.6; color: #000000; text-align: justify;">{{ $tr['summary'] }}</div>
                <div style="border-top: 1px solid #000000; margin-top: 16px; margin-bottom: 16px; height: 0; font-size: 0;">&nbsp;</div>
            @endif

            {{-- Experience --}}
            @if (!empty($tr['work_experience']))
                <div style="font-size: 11px; font-weight: bold; color: #000000; text-transform: uppercase; letter-spacing: 1.5px; text-align: center; margin-bottom: 12px;">Experience</div>

                @foreach ($tr['work_experience'] as $job)
                    <div style="margin-bottom: 14px;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                            <tr>
                                <td valign="top" style="vertical-align: top;">
                                    <span style="font-size: 12px; font-weight: bold; color: #000000;">{{ $job['title'] ?? '' }}</span>
                                    @if (!empty($job['company']))
                                        <span style="font-size: 12px; color: #000000;">, {{ $job['company'] }}</span>
                                    @endif
                                </td>
                                <td valign="top" style="vertical-align: top; text-align: right; font-size: 11px; font-style: italic; color: #000000; white-space: nowrap;">
                                    {{ $job['start_date'] ?? '' }}@if (!empty($job['end_date'])) &nbsp;&ndash;&nbsp; {{ $job['end_date'] }}@endif
                                </td>
                            </tr>
                        </table>
                        @if (!empty($job['description']))
                            <div style="font-size: 11px; color: #000000; line-height: 1.6; margin-top: 4px;">{{ $job['description'] }}</div>
                        @endif
                    </div>
                @endforeach

                <div style="border-top: 1px solid #000000; margin-top: 16px; margin-bottom: 16px; height: 0; font-size: 0;">&nbsp;</div>
            @endif

            {{-- Education --}}
            @if (!empty($tr['education']))
                <div style="font-size: 11px; font-weight: bold; color: #000000; text-transform: uppercase; letter-spacing: 1.5px; text-align: center; margin-bottom: 12px;">Education</div>

                @foreach ($tr['education'] as $edu)
                    <div style="margin-bottom: 10px;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                            <tr>
                                <td valign="top" style="vertical-align: top;">
                                    <span style="font-size: 12px; font-weight: bold; color: #000000;">{{ $edu['degree'] ?? '' }}</span>
                                    @if (!empty($edu['institution']))
                                        <span style="font-size: 12px; color: #000000;">, {{ $edu['institution'] }}</span>
                                    @endif
                                </td>
                                <td valign="top" style="vertical-align: top; text-align: right; font-size: 11px; font-style: italic; color: #000000; white-space: nowrap;">
                                    @if (!empty($edu['year'])) {{ $edu['year'] }} @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach

                <div style="border-top: 1px solid #000000; margin-top: 16px; margin-bottom: 16px; height: 0; font-size: 0;">&nbsp;</div>
            @endif

            {{-- Skills --}}
            @if (!empty($tr['skills']))
                <div style="font-size: 11px; font-weight: bold; color: #000000; text-transform: uppercase; letter-spacing: 1.5px; text-align: center; margin-bottom: 8px;">Skills</div>
                <div style="font-size: 11px; color: #000000; line-height: 1.7; text-align: center;">
                    {{ collect($tr['skills'])->filter()->implode(' · ') }}
                </div>
            @endif

        </td>
    </tr>
</table>

{{-- COVER LETTER --}}
@if ($application->cover_letter)
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; border-collapse: collapse; page-break-before: always;">
    <tr>
        <td valign="top" style="padding: 54px 64px; vertical-align: top;">
            <div style="text-align: center;">
                <div style="font-size: 22px; font-weight: bold; color: #000000; letter-spacing: 1px;">{{ strtoupper($tr['full_name'] ?? '') }}</div>
                <div style="font-size: 11px; color: #000000; margin-top: 6px;">
                    @php
                        $contactBits = array_filter([$tr['email'] ?? null, $tr['phone'] ?? null, $tr['location'] ?? null]);
                    @endphp
                    {!! implode(' &nbsp;&middot;&nbsp; ', array_map('e', $contactBits)) !!}
                </div>
            </div>
            <div style="border-top: 1px solid #000000; margin-top: 16px; margin-bottom: 26px; height: 0; font-size: 0;">&nbsp;</div>
            <div style="font-size: 11px; color: #000000; margin-bottom: 24px;">{{ now()->format('F j, Y') }}</div>
            <div style="font-size: 12px; line-height: 1.7; color: #000000; white-space: pre-line;">{{ $application->cover_letter }}</div>
        </td>
    </tr>
</table>
@endif

</body>
</html>
