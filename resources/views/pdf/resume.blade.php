<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $application->tailored_resume['full_name'] ?? 'Resume' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #1a1a1a;
            line-height: 1.5;
            background: #fff;
        }

        .page {
            padding: 36pt 42pt;
        }

        /* ── Name & contact ─────────────────────────────── */
        .header { margin-bottom: 18pt; }

        .name {
            font-size: 22pt;
            font-weight: bold;
            color: #000;
            letter-spacing: -0.5pt;
            margin-bottom: 5pt;
        }

        .contact {
            font-size: 9pt;
            color: #555;
        }

        .contact span { margin-right: 14pt; }

        /* ── Sections ───────────────────────────────────── */
        .section { margin-top: 14pt; }

        .section-title {
            font-size: 7.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.2pt;
            color: #888;
            padding-bottom: 4pt;
            border-bottom: 1pt solid #e0e0e0;
            margin-bottom: 9pt;
        }

        /* ── Summary ────────────────────────────────────── */
        .summary {
            font-size: 9.5pt;
            color: #333;
            line-height: 1.6;
        }

        /* ── Work experience ─────────────────────────────── */
        .job { margin-bottom: 10pt; }
        .job:last-child { margin-bottom: 0; }

        .job-header {
            display: table;
            width: 100%;
        }

        .job-left  { display: table-cell; }
        .job-right { display: table-cell; text-align: right; white-space: nowrap; }

        .job-title {
            font-size: 10pt;
            font-weight: bold;
            color: #111;
        }

        .job-company {
            font-size: 9pt;
            color: #555;
            margin-top: 1pt;
        }

        .job-dates {
            font-size: 8.5pt;
            color: #888;
            margin-top: 2pt;
        }

        .job-description {
            font-size: 9pt;
            color: #444;
            margin-top: 4pt;
            line-height: 1.55;
        }

        /* ── Education ──────────────────────────────────── */
        .edu { margin-bottom: 8pt; }
        .edu:last-child { margin-bottom: 0; }

        .edu-header {
            display: table;
            width: 100%;
        }

        .edu-left  { display: table-cell; }
        .edu-right { display: table-cell; text-align: right; white-space: nowrap; }

        .edu-degree {
            font-size: 10pt;
            font-weight: bold;
            color: #111;
        }

        .edu-institution {
            font-size: 9pt;
            color: #555;
            margin-top: 1pt;
        }

        .edu-year {
            font-size: 8.5pt;
            color: #888;
            margin-top: 2pt;
        }

        /* ── Skills ─────────────────────────────────────── */
        .skills-list {
            font-size: 9pt;
            color: #444;
            line-height: 1.7;
        }

        /* ── Cover letter page ──────────────────────────── */
        .page-break { page-break-before: always; }

        .cover-meta {
            font-size: 9pt;
            color: #666;
            margin-bottom: 18pt;
        }

        .cover-letter {
            font-size: 10pt;
            color: #222;
            line-height: 1.75;
            white-space: pre-line;
        }

        .cover-footer {
            margin-top: 24pt;
            font-size: 9.5pt;
            color: #222;
        }
    </style>
</head>
<body>
@php
    $tr = $application->tailored_resume;
@endphp

{{-- ── Page 1: Resume ── --}}
<div class="page">

    {{-- Header --}}
    <div class="header">
        <div class="name">{{ $tr['full_name'] ?? '' }}</div>
        <div class="contact">
            @if (!empty($tr['email']))   <span>{{ $tr['email'] }}</span> @endif
            @if (!empty($tr['phone']))   <span>{{ $tr['phone'] }}</span> @endif
            @if (!empty($tr['location'])) <span>{{ $tr['location'] }}</span> @endif
        </div>
    </div>

    {{-- Summary --}}
    @if (!empty($tr['summary']))
        <div class="section">
            <div class="section-title">Summary</div>
            <div class="summary">{{ $tr['summary'] }}</div>
        </div>
    @endif

    {{-- Work Experience --}}
    @if (!empty($tr['work_experience']))
        <div class="section">
            <div class="section-title">Experience</div>
            @foreach ($tr['work_experience'] as $job)
                <div class="job">
                    <div class="job-header">
                        <div class="job-left">
                            <div class="job-title">{{ $job['title'] ?? '' }}</div>
                            <div class="job-company">{{ $job['company'] ?? '' }}</div>
                        </div>
                        <div class="job-right">
                            <div class="job-dates">
                                {{ $job['start_date'] ?? '' }}{{ isset($job['end_date']) ? ' – ' . $job['end_date'] : '' }}
                            </div>
                        </div>
                    </div>
                    @if (!empty($job['description']))
                        <div class="job-description">{{ $job['description'] }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- Education --}}
    @if (!empty($tr['education']))
        <div class="section">
            <div class="section-title">Education</div>
            @foreach ($tr['education'] as $edu)
                <div class="edu">
                    <div class="edu-header">
                        <div class="edu-left">
                            <div class="edu-degree">{{ $edu['degree'] ?? '' }}</div>
                            <div class="edu-institution">{{ $edu['institution'] ?? '' }}</div>
                        </div>
                        <div class="edu-right">
                            @if (!empty($edu['year']))
                                <div class="edu-year">{{ $edu['year'] }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Skills --}}
    @if (!empty($tr['skills']))
        <div class="section">
            <div class="section-title">Skills</div>
            <div class="skills-list">
                {{ collect($tr['skills'])->filter()->implode(' · ') }}
            </div>
        </div>
    @endif

</div>

{{-- ── Page 2: Cover Letter ── --}}
@if ($application->cover_letter)
    <div class="page-break"></div>
    <div class="page">
        <div class="section-title" style="margin-bottom: 16pt;">Cover Letter</div>

        <div class="cover-meta">
            {{ $tr['full_name'] ?? '' }}<br>
            @if (!empty($tr['email']))    {{ $tr['email'] }}<br> @endif
            @if (!empty($tr['phone']))    {{ $tr['phone'] }}<br> @endif
            @if (!empty($tr['location'])) {{ $tr['location'] }}<br> @endif
        </div>

        <div class="cover-letter">{{ $application->cover_letter }}</div>
    </div>
@endif

</body>
</html>
