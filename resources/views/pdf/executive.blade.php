<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $application->tailored_resume['full_name'] ?? 'Resume' }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica', 'Arial', sans-serif; background: #ffffff;">

@php
    $tr = $application->tailored_resume;
@endphp

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- EXECUTIVE — Dark navy sidebar + white right column                  --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; border-collapse: collapse; table-layout: fixed; min-height: 720px;">
    <tr>

        {{-- ─── LEFT SIDEBAR (32%, navy) ────────────────────────────── --}}
        <td width="32%" valign="top" style="width: 32%; background-color: #1e293b; padding: 32px 22px; vertical-align: top; word-wrap: break-word;">

            {{-- Name --}}
            <div style="font-size: 19px; font-weight: bold; color: #ffffff; line-height: 1.25; margin-bottom: 6px; word-wrap: break-word; letter-spacing: -0.2px;">
                {{ $tr['full_name'] ?? '' }}
            </div>

            {{-- Thin accent line --}}
            <div style="width: 36px; height: 2px; background-color: #94a3b8; margin-bottom: 16px; font-size: 0;">&nbsp;</div>

            {{-- Contact --}}
            <div style="font-size: 9px; color: #cbd5e1; line-height: 2.0; margin-bottom: 22px; word-wrap: break-word;">
                @if (!empty($tr['email']))    {{ $tr['email'] }}<br> @endif
                @if (!empty($tr['phone']))    {{ $tr['phone'] }}<br> @endif
                @if (!empty($tr['location'])) {{ $tr['location'] }} @endif
            </div>

            {{-- Skills --}}
            @if (!empty($tr['skills']))
                <div style="font-size: 8px; letter-spacing: 2px; text-transform: uppercase; color: #94a3b8; margin-top: 22px; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #334155; font-weight: bold;">
                    Skills
                </div>
                <div style="font-size: 9.5px; color: #e2e8f0; line-height: 1.95; word-wrap: break-word;">
                    @foreach ($tr['skills'] as $skill)
                        @if ($skill)<div style="margin-bottom: 4px;">{{ $skill }}</div>@endif
                    @endforeach
                </div>
            @endif

            {{-- Education --}}
            @if (!empty($tr['education']))
                <div style="font-size: 8px; letter-spacing: 2px; text-transform: uppercase; color: #94a3b8; margin-top: 22px; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #334155; font-weight: bold;">
                    Education
                </div>
                @foreach ($tr['education'] as $edu)
                    <div style="margin-bottom: 12px; word-wrap: break-word;">
                        <div style="font-size: 9.5px; font-weight: bold; color: #f1f5f9; line-height: 1.4;">{{ $edu['degree'] ?? '' }}</div>
                        <div style="font-size: 8.5px; color: #94a3b8; line-height: 1.5; margin-top: 2px;">
                            {{ $edu['institution'] ?? '' }}@if (!empty($edu['year'])) &middot; {{ $edu['year'] }}@endif
                        </div>
                    </div>
                @endforeach
            @endif
        </td>

        {{-- ─── RIGHT COLUMN (68%, white) ──────────────────────────── --}}
        <td width="68%" valign="top" style="width: 68%; background-color: #ffffff; padding: 32px; vertical-align: top; word-wrap: break-word;">

            {{-- Name repeat --}}
            <div style="font-size: 26px; font-weight: bold; color: #0f172a; line-height: 1.15; margin-bottom: 4px; letter-spacing: -0.4px;">
                {{ $tr['full_name'] ?? '' }}
            </div>
            <div style="font-size: 9.5px; color: #64748b; line-height: 1.5; margin-bottom: 6px;">
                @if (!empty($tr['email']))    {{ $tr['email'] }} @endif
                @if (!empty($tr['phone']))    &nbsp;&middot;&nbsp; {{ $tr['phone'] }} @endif
                @if (!empty($tr['location'])) &nbsp;&middot;&nbsp; {{ $tr['location'] }} @endif
            </div>

            {{-- Summary --}}
            @if (!empty($tr['summary']))
                <div style="font-size: 8.5px; letter-spacing: 2px; text-transform: uppercase; color: #1e293b; margin-top: 26px; margin-bottom: 5px; font-weight: bold;">Summary</div>
                <div style="border-bottom: 2px solid #1e293b; width: 28px; margin-bottom: 12px; height: 0; font-size: 0;">&nbsp;</div>
                <div style="font-size: 10.5px; line-height: 1.7; color: #334155;">{{ $tr['summary'] }}</div>
            @endif

            {{-- Experience --}}
            @if (!empty($tr['work_experience']))
                <div style="font-size: 8.5px; letter-spacing: 2px; text-transform: uppercase; color: #1e293b; margin-top: 26px; margin-bottom: 5px; font-weight: bold;">Experience</div>
                <div style="border-bottom: 2px solid #1e293b; width: 28px; margin-bottom: 14px; height: 0; font-size: 0;">&nbsp;</div>

                @foreach ($tr['work_experience'] as $job)
                    <div style="margin-bottom: 18px;">
                        <div style="font-size: 12px; font-weight: bold; color: #0f172a; line-height: 1.3;">{{ $job['title'] ?? '' }}</div>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; margin-top: 3px; margin-bottom: 6px;">
                            <tr>
                                <td valign="top" style="font-size: 10.5px; color: #475569; font-style: italic; vertical-align: top;">{{ $job['company'] ?? '' }}</td>
                                <td valign="top" style="font-size: 9.5px; color: #94a3b8; text-align: right; white-space: nowrap; vertical-align: top;">
                                    {{ $job['start_date'] ?? '' }}@if (!empty($job['end_date'])) &nbsp;&ndash;&nbsp; {{ $job['end_date'] }}@endif
                                </td>
                            </tr>
                        </table>
                        @if (!empty($job['description']))
                            <div style="font-size: 10.5px; color: #475569; line-height: 1.7; margin-top: 4px;">{{ $job['description'] }}</div>
                        @endif
                    </div>
                @endforeach
            @endif

        </td>
    </tr>
</table>

{{-- COVER LETTER --}}
@if ($application->cover_letter)
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; border-collapse: collapse; page-break-before: always;">
    <tr>
        <td valign="top" style="padding: 56px; background-color: #ffffff; vertical-align: top;">
            <div style="font-size: 22px; font-weight: bold; color: #0f172a; line-height: 1.2; letter-spacing: -0.3px;">{{ $tr['full_name'] ?? '' }}</div>
            <div style="font-size: 10px; color: #64748b; margin-top: 4px;">
                @php
                    $contactBits = array_filter([$tr['email'] ?? null, $tr['phone'] ?? null, $tr['location'] ?? null]);
                @endphp
                {!! implode(' &nbsp;&middot;&nbsp; ', array_map('e', $contactBits)) !!}
            </div>
            <div style="border-top: 2px solid #1e293b; width: 36px; margin-top: 14px; margin-bottom: 28px; height: 0; font-size: 0;">&nbsp;</div>
            <div style="font-size: 10px; color: #94a3b8; margin-bottom: 24px;">{{ now()->format('F j, Y') }}</div>
            <div style="font-size: 11px; line-height: 1.75; color: #334155; white-space: pre-line;">{{ $application->cover_letter }}</div>
        </td>
    </tr>
</table>
@endif

</body>
</html>
