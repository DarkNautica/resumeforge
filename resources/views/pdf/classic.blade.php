<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Arial, sans-serif; font-size: 10.5px; color: #1a1a1a; background: #fff; }
.page { padding: 48px 52px; }
.name { font-size: 26px; font-weight: bold; text-align: center; letter-spacing: 1px; color: #000; margin-bottom: 6px; }
.contact { text-align: center; font-size: 9.5px; color: #555; letter-spacing: 0.5px; margin-bottom: 18px; }
.divider { border: none; border-top: 2px solid #000; margin-bottom: 18px; }
.section-header { font-size: 9px; font-weight: bold; letter-spacing: 2.5px; text-transform: uppercase; color: #000; border-bottom: 1px solid #ccc; padding-bottom: 4px; margin-bottom: 12px; margin-top: 22px; }
.summary { font-size: 10px; line-height: 1.7; color: #333; margin-bottom: 4px; }
.exp-title { font-size: 11px; font-weight: bold; color: #000; }
.exp-meta { font-size: 9.5px; color: #555; margin-bottom: 6px; }
.exp-desc { font-size: 10px; line-height: 1.65; color: #444; }
.exp-entry { margin-bottom: 16px; }
.skills-grid { font-size: 10px; color: #333; line-height: 2.0; }
.cover-page { padding: 48px 52px; page-break-before: always; }
.cover-name { font-size: 20px; font-weight: bold; color: #000; margin-bottom: 4px; }
.cover-contact { font-size: 9.5px; color: #555; margin-bottom: 4px; }
.cover-hr { border: none; border-top: 1px solid #ccc; margin: 14px 0 20px; }
.cover-date { font-size: 10px; color: #555; margin-bottom: 16px; }
.cover-body { font-size: 10.5px; line-height: 1.75; color: #333; margin-bottom: 14px; }
.cover-sign { font-size: 10.5px; color: #333; margin-top: 24px; }
</style>
</head>
<body>
<div class="page">
<div class="name">{{ strtoupper($resume['full_name'] ?? $application->resume->full_name ?? '') }}</div>
<div class="contact">{{ $resume['email'] ?? $application->resume->email }} &nbsp;&middot;&nbsp; {{ $resume['phone'] ?? $application->resume->phone }} &nbsp;&middot;&nbsp; {{ $resume['location'] ?? $application->resume->location }}</div>
<hr class="divider">

@if($resume['summary'] ?? null)
<div class="section-header">Summary</div>
<div class="summary">{{ $resume['summary'] }}</div>
@endif

@if(!empty($resume['work_experience']))
<div class="section-header">Experience</div>
@foreach($resume['work_experience'] as $job)
<div class="exp-entry">
<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td><span class="exp-title">{{ $job['title'] ?? '' }}</span></td>
<td align="right"><span style="font-size:9.5px;color:#555;">{{ $job['start_date'] ?? '' }}{{ isset($job['end_date']) ? ' &ndash; ' . $job['end_date'] : ' &ndash; Present' }}</span></td>
</tr></table>
<div class="exp-meta">{{ $job['company'] ?? '' }}</div>
<div class="exp-desc">{{ $job['description'] ?? '' }}</div>
</div>
@endforeach
@endif

@if(!empty($resume['education']))
<div class="section-header">Education</div>
@foreach($resume['education'] as $edu)
<div class="exp-entry">
<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td><span class="exp-title">{{ $edu['degree'] ?? '' }}</span></td>
<td align="right"><span style="font-size:9.5px;color:#555;">{{ $edu['year'] ?? '' }}</span></td>
</tr></table>
<div class="exp-meta">{{ $edu['institution'] ?? '' }}</div>
</div>
@endforeach
@endif

@if(!empty($resume['skills']))
<div class="section-header">Skills</div>
<div class="skills-grid">{!! implode(' &nbsp;&middot;&nbsp; ', array_map('e', array_filter($resume['skills']))) !!}</div>
@endif
</div>

@if($coverLetter)
<div class="cover-page">
<div class="cover-name">{{ $resume['full_name'] ?? $application->resume->full_name }}</div>
<div class="cover-contact">{{ $resume['email'] ?? $application->resume->email }} &nbsp;&middot;&nbsp; {{ $resume['phone'] ?? $application->resume->phone }}</div>
<hr class="cover-hr">
<div class="cover-date">{{ now()->format('F j, Y') }}</div>
<div class="cover-body">Dear {{ $application->company_name }} Hiring Team,</div>
@foreach(explode("\n\n", $coverLetter) as $paragraph)
@if(trim($paragraph))
<div class="cover-body">{{ trim($paragraph) }}</div>
@endif
@endforeach
<div class="cover-sign">Sincerely,<br><br><strong>{{ $resume['full_name'] ?? $application->resume->full_name }}</strong><br>{{ $resume['email'] ?? $application->resume->email }} &nbsp;|&nbsp; {{ $resume['phone'] ?? $application->resume->phone }}</div>
</div>
@endif
</body>
</html>
