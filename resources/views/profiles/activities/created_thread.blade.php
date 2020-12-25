<v-activity-card>
    <template #header>
        <span class="font-semibold">Started a new Conversation </span>
        <a href="{{$activity->subject->path()}}">{{$activity->subject->title}}</a>
    </template>
    <template #body>
        <p>{{$activity->subject->body}}</p>
    </template>
</v-activity-card>