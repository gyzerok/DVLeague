var newsArray = new Array();

window.onload = function()
{
    var newsCount;

    newsCount = document.getElementsByClassName('news_wrapper').length;
    for (var i = newsCount - 1; i >= 0; i--)
    {
        newsArray[i] = document.getElementById('content').removeChild(document.getElementsByClassName('news_wrapper')[i]);
    }
    InsertNews(newsArray[0]);
}

function InsertNews(news)
{
    document.getElementById('content').insertBefore(news, document.getElementById('news_list'));
}

function SwapNews(elem)
{
    //if (this.getOwnPropertyNames() == "active");
    document.getElementById('content').removeChild(document.getElementsByClassName('news_wrapper')[0]);
    elem.attribut
    InsertNews(newsArray[elem.id]);
}