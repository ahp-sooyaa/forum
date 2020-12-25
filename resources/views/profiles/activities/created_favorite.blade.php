<v-activity-card>
    <template #header>
        <span class="font-semibold">Favorited a reply on </span>
        <a href="{{$activity->subject->favorited->path()}}">
            {{$activity->subject->favorited->thread->title}}
        </a>
    </template>
    <template #body>
        <p>{{$activity->subject->favorited->body}}</p>
    </template>
</v-activity-card>