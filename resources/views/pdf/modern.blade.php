<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $application->tailored_resume['full_name'] ?? 'Resume' }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica', 'Arial', sans-serif; background: #ffffff; color: #1a1a1a;">

@php
    $tr = $application->tailored_resume;
@endphp

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- MODERN — Single column, full white, lots of whitespace              --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; border-collapse: collapse;">
    <tr>
        <td valign="top" style="padding: 56px 64px; vertical-align: top; background-color: #ffffff;">

            {{-- Name --}}
            <div style="font-size: 32px; font-weight: bold; color: #111111; line-height: 1.1; letter-spacing: -0.5px; margin-bottom: 8px;">
                {{ $tr['full_name'] ?? '' }}
            </div>

            {{-- Thin colored line under name --}}
            <div style="width: 56px; height: 3px; background-color: #64748b; font-size: 0; margin-bottom: 14px;">&nbsp;</div>

            {{-- Contact --}}
            <div style="font-size: 10px; color: #6b7280; line-height: 1.6;">
                @if (!empty($tr['email']))    {{ $tr['email'] }} @endif
                @if (!empty($tr['phone']))    &nbsp;&middot;&nbsp; {{ $tr['phone'] }} @endif
                @if (!empty($tr['location'])) &nbsp;&middot;&nbsp; {{ $tr['location'] }} @endif
            </div>

            {{-- Summary --}}
            @if (!empty($tr['summary']))
                <div style="margin-top: 36px; padding-left: 14px; border-left: 3px solid #94a3b8;">
                    <div style="font-size: 9px; letter-spacing: 2px; text-transform: uppercase; color: #475569; font-weight: bold; margin-bottom: 8px;">Summary</div>
                    <div style="font-size: 11px; line-height: 1.75; color: #374151;">{{ $tr['summary'] }}</div>
                </div>
            @endif

            {{-- Experience --}}
            @if (!empty($tr['work_experience']))
                <div style="margin-top: 32px; padding-left: 14px; border-left: 3px solid #94a3b8;">
                    <div style="font-size: 9px; letter-spacing: 2px; text-transform: uppercase; color: #475569; font-weight: bold; margin-bottom: 14px;">Experience</div>

                    @foreach ($tr['work_experience'] as $job)
                        <div style="margin-bottom: 22px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                                <tr>
                                    <td valign="top" style="vertical-align: top;">
                                        <div style="font-size: 12.5px; font-weight: bold; color: #111111; line-height: 1.3;">{{ $job['title'] ?? '' }}</div>
                                        <div style="font-size: 10.5px; color: #6b7280; margin-top: 2px;">{{ $job['company'] ?? '' }}</div>
                                    </td>
                                    <td valign="top" style="vertical-align: top; text-align: right; white-space: nowrap; font-size: 9.5px; color: #94a3b8;">
                                        {{ $job['start_date'] ?? '' }}@if (!empty($job['end_date'])) &nbsp;&ndash;&nbsp; {{ $job['end_date'] }}@endif
                                    </td>
                                </tr>
                            </table>
                            @if (!empty($job['description']))
                                <div style="font-size: 10.5px; color: #4b5563; line-height: 1.7; margin-top: 6px;">{{ $job['description'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Skills (two-column) --}}
            @if (!empty($tr['skills']))
                @php
                    $skillsClean = array_values(array_filter($tr['skills']));
                    $half = (int) ceil(count($skillsClean) / 2);
                    $skillsLeft  = array_slice($skillsClean, 0, $half);
                    $skillsRight = array_slice($skillsClean, $half);
                @endphp
                <div style="margin-top: 32px; padding-left: 14px; border-left: 3px solid #94a3b8;">
                    <div style="font-size: 9px; letter-spacing: 2px; text-transform: uppercase; color: #475569; font-weight: bold; margin-bottom: 12px;">Skills</div>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                        <tr>
                            <td width="50%" valign="top" style="width: 50%; vertical-align: top; padding-right: 12px;">
                                @foreach ($skillsLeft as $skill)
                                    <div style="font-size: 10.5px; color: #4b5563; line-height: 1.9;">&middot; {{ $skill }}</div>
                                @endforeach
                            </td>
                            <td width="50%" valign="top" style="width: 50%; vertical-align: top; padding-left: 12px;">
                                @foreach ($skillsRight as $skill)
                                    <div style="font-size: 10.5px; color: #4b5563; line-height: 1.9;">&middot; {{ $skill }}</div>
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            @endif

            {{-- Education --}}
            @if (!empty($tr['education']))
                <div style="margin-top: 32px; padding-left: 14px; border-left: 3px solid #94a3b8;">
                    <div style="font-size: 9px; letter-spacing: 2px; text-transform: uppercase; color: #475569; font-weight: bold; margin-bottom: 12px;">Education</div>
                    @foreach ($tr['education'] as $edu)
                        <div style="margin-bottom: 12px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                                <tr>
                                    <td valign="top" style="vertical-align: top;">
                                        <div style="font-size: 11.5px; font-weight: bold; color: #111111;">{{ $edu['degree'] ?? '' }}</div>
                                        <div style="font-size: 10px; color: #6b7280; margin-top: 1px;">{{ $edu['institution'] ?? '' }}</div>
                                    </td>
                                    <td valign="top" style="vertical-align: top; text-align: right; font-size: 9.5px; color: #94a3b8; white-space: nowrap;">
                                        @if (!empty($edu['year'])) {{ $edu['year'] }} @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    @endforeach
                </div>
            @endif

        </td>
    </tr>
</table>

{{-- COVER LETTER --}}
@if ($application->cover_letter)
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; border-collapse: collapse; page-break-before: always;">
    <tr>
        <td valign="top" style="padding: 56px 64px; vertical-align: top; background-color: #ffffff;">
            <div style="font-size: 24px; font-weight: bold; color: #111111; line-height: 1.15; letter-spacing: -0.4px;">{{ $tr['full_name'] ?? '' }}</div>
            <div style="width: 56px; height: 3px; background-color: #64748b; font-size: 0; margin-top: 8px; margin-bottom: 12px;">&nbsp;</div>
            <div style="font-size: 10px; color: #6b7280;">
                @php
                    $contactBits = array_filter([$tr['email'] ?? null, $tr['phone'] ?? null, $tr['location'] ?? null]);
                @endphp
                {!! implode(' &nbsp;&middot;&nbsp; ', array_map('e', $contactBits)) !!}
            </div>
            <div style="font-size: 10px; color: #94a3b8; margin-top: 32px; margin-bottom: 24px;">{{ now()->format('F j, Y') }}</div>
            <div style="font-size: 11px; line-height: 1.75; color: #374151; white-space: pre-line;">{{ $application->cover_letter }}</div>
        </td>
    </tr>
</table>
@endif

</body>
</html>
