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
], function($nos) {
    return function(appDesk) {
        return {
            tab : {
                label : appDesk.i18n('Blog'),
                iconUrl : 'static/apps/noviusos_blog/img/32/blog.png'
            },
            actions : {
                update : {
                    action : function(item) {
                        $nos.nos.tabs.open({
                            url     : "admin/noviusos_blog/form/edit/" + item.id,
                            label   : appDesk.i18n('Edit')._()
                        });
                    },
                    label : appDesk.i18n('Edit'),
                    name : 'edit',
                    primary : true,
                    icon : 'pencil'
                },
                'delete' : {
                    action : function(item) {
                        $nos.nos.ajax.request({
                            url: "admin/noviusos_blog/list/delete/" + item.id,
                            data: {},
                            success: function(response) {
                                if (response.success) {
                                    $nos.notify("Suppression réalisée !");
                                    $nos.nos.dispatchEvent({
                                        event : 'reload',
                                        target : 'noviusos_blog'
                                    })
                                } else {
                                    $nos.notify("Erreur lors de la suppression !", "error");
                                }
                            }
                        });
                    },
                    label : appDesk.i18n('Delete'),
                    name : 'delete',
                    primary : true,
                    icon : 'trash'
                }
                /*
                'visualise' : {
                    label : 'Visualise',
                    name : 'visualise',
                    primary : true,
                    iconClasses : 'nos-icon16 nos-icon16-eye',
                    action : function(item) {
                        window.open(item.visualise);
                    }
                }
                */
            },
            reload : 'noviusos_blog',
            appdesk : {
                adds : {
                    post : {
                        label : appDesk.i18n('Add a post'),
                        action : function() {
                            $nos.nos.tabs.add({
                                url     : 'admin/noviusos_blog/form/edit',
                                label   : appDesk.i18n('Edit')._()
                            });
                        }
                    },
                    category : {
                        label : appDesk.i18n('Add a category'),
                        url : 'admin/noviusos_blog/categoryform'
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
                            actions : ['update', 'delete'/*, 'visualise'*/]
                        }
                    }
                },
                inspectors : {
                    authors : {
                        widget_id : 'noviusos_blog_authors',
                        label : appDesk.i18n('Authors'),
                        url : 'admin/noviusos_blog/inspector/author/list',
                        grid : {
                            columns : {
                                title : {
                                    headerText : appDesk.i18n('Author'),
                                    dataKey : 'title'
                                },
                                actions : {
                                    showOnlyArrow : true,
                                    actions : [
                                        {
                                            action : function(item) {
                                                $nos.nos.tabs.add({
                                                    iframe : true,
                                                    url     : "admin/noviusos_blog/form?id=" + item.id,
                                                    label   : "Update"
                                                });
                                            },
                                            label : appDesk.i18n('Update')
                                        }
                                    ]
                                }
                            },
                            urlJson : 'admin/noviusos_blog/inspector/author/json'
                        },
                        inputName : 'blog_author_id[]',
                        vertical : true
                    },
                    categories : {
                        widget_id : 'noviusos_blog_categories',
                        label : appDesk.i18n('Categories'),
                        vertical : true,
                        url : 'admin/noviusos_blog/inspector/category/list',
                        treeGrid : {
                            columns : {
                                title : {
                                    headerText : appDesk.i18n('Category'),
                                    dataKey : 'title'
                                },
                                actions : {
                                    showOnlyArrow : true,
                                    actions : [
                                        {
                                            action : function(item) {
                                                $nos.nos.tabs.open({
                                                    iframe : true,
                                                    url     : "admin/noviusos_blog/form?id=" + item.id,
                                                    label   : appDesk.i18n('Update')._()
                                                });
                                            },
                                            label : appDesk.i18n('Update')
                                        },
                                        {
                                            action : function(item) {
                                                $nos.nos.ajax.request({
                                                    url: "admin/noviusos_blog/inspector/category/delete/" + item.id,
                                                    data: {},
                                                    success: function(response) {
                                                        if (response.success) {
                                                            $nos.notify("Successfully deleted!");
                                                            $nos.nos.dispatchEvent({
                                                                event : 'reload',
                                                                target : 'noviusos_blog'
                                                            })
                                                        } else {
                                                            $nos.notify("Error when deleting!", "error");
                                                        }
                                                    }
                                                });
                                            },
                                            label : appDesk.i18n('Delete')
                                        }
                                    ]
                                }
                            },
                            treeUrl : 'admin/noviusos_blog/inspector/category/json'
                        },
                        inputName : 'blgc_id[]'
                    },
                    tags : {
                        widget_id : 'noviusos_blog_tags',
                        hide : true,
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
                                    showOnlyArrow : true,
                                    actions : [
                                        {
                                            action : function(item) {
                                                $nos.nos.tabs.open({
                                                    iframe : true,
                                                    url     : "admin/noviusos_blog/form?id=" + item.id,
                                                    label   : appDesk.i18n('Edit')
                                                });
                                            },
                                            label : appDesk.i18n('Edit')
                                        },
                                        {
                                            action : function(item) {
                                                $nos.nos.ajax.request({
                                                    url: "admin/noviusos_blog/inspector/category/delete/" + item.id,
                                                    data: {},
                                                    success: function(response) {
                                                        if (response.success) {
                                                            $nos.notify("Successfully deleted!");
                                                            $nos.nos.dispatchEvent({
                                                                event : 'reload',
                                                                target : 'noviusos_blog'
                                                            })
                                                        } else {
                                                            $nos.notify("Error when deleting.", "error");
                                                        }
                                                    }
                                                });
                                            },
                                            label : appDesk.i18n('Delete')
                                        }
                                    ]
                                }
                            }
                        },
                        inputName : 'tag_id[]'
                    },
                    publishDate : {
                        widget_id : 'noviusos_blog_publishDate',
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
