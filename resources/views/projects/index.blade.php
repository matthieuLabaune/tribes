<!DOCTYPE html>

<html>
<head>
    <title>

    </title>
</head>
<body>

<h1>
    Tribes
</h1>

<ul>
    @forelse($projects as $project)
        <li>
            <a href="{{route('projects.show', $project->id)}}">
                {{$project->title}}
            </a>
        </li>

    @empty
        <li> No projects yet.</li>
    @endforelse
</ul>
</body>
</html>