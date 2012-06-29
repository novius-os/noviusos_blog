/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

define([
    'jquery-nos'
], function($) {
    return function(appDesk) {
        return {
            tab : {
                label : appDesk.i18n('Blog'),
                iconUrl : 'static/apps/noviusos_blog/img/32/blog.png'
            },
            actions : {
                update : {
                    action : function(item, ui) {
                        $(ui).nosTabs({
                            url     : "admin/noviusos_blog/form/crud/" + item.id,
                            label   : appDesk.i18n('Edit')._()
                        });
                    },
                    label : appDesk.i18n('Edit'),
                    name : 'edit',
                    primary : true,
                    icon : 'pencil'
                },
                'delete' : {
                    action : function(item, ui) {
                        $.appDesk = appDesk;
                        $(ui).nosConfirmationDialog({
                            contentUrl: 'admin/noviusos_blog/blog/delete/' + item.id,
                            title: appDesk.i18n('Delete a post')._(),
                            confirmed: function($dialog) {
                                $dialog.nosAjax({
                                    url : 'admin/noviusos_blog/blog/delete_confirm',
                                    method : 'POST',
                                    data : $dialog.find('form').serialize(),
                                    success : function(json) {
                                        $.nosDispatchEvent('reload.noviusos_blog');
                                    }
                                });
                            },
                            appDesk: appDesk
                        });
                    },
                    label : appDesk.i18n('Delete'),
                    name : 'delete',
                    primary : true,
                    icon : 'trash'
                },
                'visualise' : {
                    label : 'Visualise',
                    name : 'visualise',
                    primary : true,
                    iconClasses : 'nos-icon16 nos-icon16-eye',
                    action : function(item) {
                        window.open(item.url + '?_preview=1');
                    }
                }
            },
            reloadEvent : 'noviusos_blog',
            appdesk : {
                adds : {
                    post : {
                        label : appDesk.i18n('Add a post'),
                        action : function(ui, appdesk) {
                            $(ui).nosTabs('add', {
                                url     : 'admin/noviusos_blog/form/crud?lang=' + appdesk.lang,
                                label   : appDesk.i18n('Add a new post')._()
                            });
                        }
                    }
                },
                splittersVertical :  250,
                grid : {
                    proxyUrl : 'admin/noviusos_blog/list/json',
                    columns : {
                        title : {
                            headerText : appDesk.i18n('Title'),
                            dataKey : 'title'
                        },
                        lang : {
                            lang : true
                        },
                        author : {
                            headerText : appDesk.i18n('Author'),
                            dataKey : 'author'
                        },
                        date : {
                            headerText : appDesk.i18n('Date'),
                            dataKey : 'date',
                            dataFormatString  : 'MM/dd/yyyy HH:mm:ss',
                            showFilter : false,
                            sortDirection : 'descending'
                        },
                        published : {
                            headerText : appDesk.i18n('Status'),
                            dataKey : 'publication_status'
                        },
                        actions : {
                            actions : ['update', 'delete', 'visualise']
                        }
                    }
                },
                inspectors : {
                    authors : {
                        reloadEvent : 'nos_user',
                        label : appDesk.i18n('Authors'),
                        url : 'admin/noviusos_blog/inspector/author/list',
                        grid : {
                            columns : {
                                title : {
                                    headerText : appDesk.i18n('Author'),
                                    dataKey : 'title'
                                }
                            },
                            urlJson : 'admin/noviusos_blog/inspector/author/json'
                        },
                        inputName : 'blog_author_id[]',
                        vertical : true
                    },
                    tags : {
                        reloadEvent : 'noviusos_blog_tags',
                        label : appDesk.i18n('Tags'),
                        url : 'admin/noviusos_blog/inspector/tag/list',
                        grid : {
                            urlJson : 'admin/noviusos_blog/inspector/tag/json',
                            columns : {
                                title : {
                                    headerText : appDesk.i18n('Tag'),
                                    dataKey : 'title'
                                },
                                actions : {
                                    actions : [
                                        {
                                            action : function(item, ui) {
                                                $(ui).nosConfirmationDialog({
                                                    contentUrl: 'admin/noviusos_blog/tag/delete/' + item.id,
                                                    title: appDesk.i18n('Delete a tag')._(),
                                                    confirmed: function($dialog) {
                                                        $dialog.nosAjax({
                                                            url : 'admin/noviusos_blog/tag/delete_confirm',
                                                            method : 'POST',
                                                            data : $dialog.find('form').serialize(),
                                                            success : function(json) {
                                                                $.nosDispatchEvent('reload.noviusos_blog_tags');
                                                            }
                                                        });
                                                    },
                                                    appDesk: appDesk
                                                });
                                            },
                                            label : appDesk.i18n('Delete'),
                                            primary : true,
                                            icon : 'trash'
                                        }
                                    ]
                                }
                            }
                        },
                        inputName : 'tag_id[]',
                        vertical: true
                    },
                    publishDate : {
                        vertical : true,
                        label : appDesk.i18n('Publish date'),
                        url : 'admin/noviusos_blog/inspector/date/list',
                        inputName : 'blog_created_at'
                    }
                }
            }
        }
    }
});
