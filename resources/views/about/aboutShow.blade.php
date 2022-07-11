<x-app>
{{Breadcrumbs::render('about')}}
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <main class="about">
                <div class="titleWrapper">
                    <h1 class="about__title">Works</h1>
                    <h2 class="about__title--japanese">実績</h2>
                </div>

                <div class="about__blogWrapper">
                    @if(count($posts) === 0)
                    <p>まだ実績がありません</p>
                    @endif
                    @foreach($posts as $post)
                    <a href="{{route('post.postShow',$post)}}" class="BlogCard">
                        <span class="BlogCard__category">{{ $post->category->name }}</span>
                        <div class="BlogCard__image"><img
                                src="{{asset('storage/public/eyeCatchImage/'.$post->eyeCatchImage)}}"
                                alt="eyeCatchImage"></div>
                        <h3 class="BlogCard__title">{{Str::limit($post->title,20,'...')}}</h3>
                    </a>
                    @endforeach
                </div>
            </main>

            <section class="selfAbout">
                <div class="titleWrapper">
                    <h1 class="selfAbout__title">About Me</h1>
                    <h2 class="selfAbout__title--japanese">自己紹介</h2>
                </div>

                <div class="selfAbout__body">
                    <p class="lead">こんにちは！Jippy(じっぴー)といいます。<br>
                        このブログを作るに至った動機と、そのきっかけを生い立ちを交えながら執筆していこうと思います。ちなみにブログは初めての試みなので、稚拙な文章に関しては寛大な心でどうかお許しください。
                    </p>

                    <h1>簡単な自己紹介</h1>
                    <p>現在25歳（2022年6月時点）。フリーターです。放射線技師のアルバイトをしながら、暇ができたらプログラミングをしています。
                    </p>
                    <h3>好き</h3>
                    <ul>
                        <li>軽い運動</li>
                        <li>掃除</li>
                        <li>こたつに入りながら詰将棋</li>
                        <li>お菓子食べながら映画</li>
                        <li>寿司、ラーメン、パフェ、茶碗蒸し</li>
                        <li>スマブラ</li>
                    </ul>

                    <h1>プログラマーを目指す以前</h1>
                    <p>
                        元々放射線技師という仕事をしておりました。今もアルバイトとして携わっています。<br>
                        最近はドラマ化の影響もあってそんなに珍しい仕事でも無くなってきたのか、認知されるようになって嬉しいです。<br>
                        実はこの放射線技師という仕事、医療に興味があるから目指した訳ではなく、安定した生活を望んで選択した職業でした。当時高校生の僕は安定思考で公務員や医療系の仕事について可もなく不可もなくみたいな人生を想像しながら進路を考えていました。<br>
                        <br>
                        そんな考えを持って医療系に進むことを決めた僕は、なんとなく最先端医療機器かっこいいなぁと思ったので放射線技師を目指すことを決めます。<br>
                        <br>
                        そして無事国家試験に合格。当時21歳。そこから2年半は放射線技師として働くことになります。
                    </p>

                    <h1>人生を考えるきっかけ</h1>
                    <p>
                        放射線技師に限らず全てのお仕事にも言えることかもしれませんが、仕事の性質上患者さんや周りのコメディカルの方々から直接感謝されることもあるので、この仕事にやりがいを感じることができていました。
                        しかし医療に興味がない＋昇給がほぼないので頑張り続けるモチベーションが湧きません。瞬発力を求められる医療の現場では、じっくり考えることが得意な僕の長所も活かしにくいです。
                        何だかなーーーーと思いながら仕事を続けていました。<br>
                        <br>
                        ある日友人の誘いで大阪市のカフェに行くことになり、そのカフェにてマルチビジネスで成果をあげているカフェの常連さんとお話しすることになります。<br>
                        常連の方に「やりたいことは何なん？？」と何度も何度も聞かれました。
                        返答に困りました。<br>
                        その日はそのまま帰りましたが、なんだかモヤモヤした気持ちが続いて、そのカフェに何度か足を運ぶようになりました。
                        そこから安定した生活に疑問を持ちはじめる僕。<br>
                        「安定」より「やりたいこと」をして楽しく生きていくことの方が人生の本質なんじゃないのか？という結論に至った僕は、その常連さんに感謝の気持ちを伝えた後別れを告げ、やりたいこと探しを始めます。
                    </p>

                    <h1>プログラミングに触れる</h1>
                    <p>
                        やりたいことを探して色々なものを調べ始めます。アフィリエイトやおもしろそうな資格、当時筋トレにもはまりつつあったのでジムトレーナーなどなど。その中でも目を引いたのはプログラミングでした。<br>
                        なんかITマスターとかハッカーってカッコイイ！と思った僕は「Progate」という駆け出しプログラマーの登竜門的なサイトがあることを知ります。<br>
                        そしてprogateでプログラミングに触れた結果「なんだかわからないけど超楽しい！」と感動しました。<br>
                        もともと最先端の技術とか装置ってかっこいい！と思って放射線技師になったこともあり、パソコンを操作して物を作ることは最先端ですごいことをしている気分になれました。<br>
                        プログラマーとして生きていくことを決め、次の日の朝には辞表を出し、晴れてやりたいこと人生の最初の一歩を踏み出した僕。これまでやるべきこと人生だった反動なのでしょうか？その時の開放感とこれからのワクワクたるや計り知れないほど気持ちよかったのを覚えています笑　このとき24歳でした。
                    </p>

                    <p>
                        実はこの後、プログラミングはデザインや営業と相性がいいと教えてもらい、そっちに流れてしまうも、デザインがあまり楽しめずに惨敗。コードを書いてる時がやっぱり楽しいのでしばらくはプログラミング一本でいこうと思っています。
                    </p>
                </div>
            </section>
        </div>
        <x-sidebar />
    </div>
</div>
</x-app>
