<?php
    // Comprueba si el archivo fue cargado directamente desde el navegador
    if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
        // Error al cargar el archivo
        echo utf8_decode('No tiene permitido ver el contenido de este documento.');
        exit;
    }

    // Cuadro de diálogo Misión
    HtmlGen::comment('Cuadro de diálogo Misión');
    HtmlGen::div(array(
        'class' => 'modal fade',
        'id' => 'mision',
        'tabindex' => '-1',
        'role' => 'dialog'
    ), function () use ($nosotros, $richTextFilter) {
        HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($nosotros, $richTextFilter) {
            HtmlGen::div(array('class' => 'modal-content'), function () use ($nosotros, $richTextFilter) {
                HtmlGen::div(array('class' => 'modal-header'), function () {
                    HtmlGen::button(array(
                        'type' => 'button',
                        'class' => 'close',
                        'data-dismiss' => 'modal',
                        'aria-label' => 'Cerrar'
                    ), function () {
                        HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                    });
                    HtmlGen::h3(array('class' => 'modal-title'), 'Misión');
                });
                HtmlGen::div(array('class' => 'modal-body'), function () use ($nosotros, $richTextFilter) {
                    HtmlGen::div(array('class' => 'text-justify'), $richTextFilter->purify($nosotros['Mision']));
                });
            });
        });
    });

    // Cuadro de diálogo Visión
    HtmlGen::comment('Cuadro de diálogo Visión');
    HtmlGen::div(array(
        'class' => 'modal fade',
        'id' => 'vision',
        'tabindex' => '-1',
        'role' => 'dialog'
    ), function () use ($nosotros, $richTextFilter) {
        HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($nosotros, $richTextFilter) {
            HtmlGen::div(array('class' => 'modal-content'), function () use ($nosotros, $richTextFilter) {
                HtmlGen::div(array('class' => 'modal-header'), function () {
                    HtmlGen::button(array(
                        'type' => 'button',
                        'class' => 'close',
                        'data-dismiss' => 'modal',
                        'aria-label' => 'Cerrar'
                    ), function () {
                        HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                    });
                    HtmlGen::h3(array('class' => 'modal-title'), 'Visión');
                });
                HtmlGen::div(array('class' => 'modal-body'), function () use ($nosotros, $richTextFilter) {
                    HtmlGen::div(array('class' => 'text-justify'), $richTextFilter->purify($nosotros['Vision']));
                });
            });
        });
    });

    // Cuadro de diálogo Organización
    HtmlGen::comment('Cuadro de diálogo Organización');
    HtmlGen::div(array(
        'class' => 'modal fade',
        'id' => 'organizacion',
        'tabindex' => '-1',
        'role' => 'dialog'
    ), function () use ($nosotros, $richTextFilter) {
        HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($nosotros, $richTextFilter) {
            HtmlGen::div(array('class' => 'modal-content'), function () use ($nosotros, $richTextFilter) {
                HtmlGen::div(array('class' => 'modal-header'), function () {
                    HtmlGen::button(array(
                        'type' => 'button',
                        'class' => 'close',
                        'data-dismiss' => 'modal',
                        'aria-label' => 'Cerrar'
                    ), function () {
                        HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                    });
                    HtmlGen::h3(array('class' => 'modal-title'), 'Organización');
                });
                HtmlGen::div(array('class' => 'modal-body'), function () use ($nosotros, $richTextFilter) {
                    HtmlGen::div(array('class' => 'text-justify'), $richTextFilter->purify($nosotros['Organizacion']));
                });
            });
        });
    });

    // Cuadro de diálogo Perfil Profesional
    HtmlGen::comment('Cuadro de diálogo Perfil Profesional');
    HtmlGen::div(array(
        'class' => 'modal fade',
        'id' => 'perfil-profesional',
        'tabindex' => '-1',
        'role' => 'dialog'
    ), function () use ($nosotros, $richTextFilter) {
        HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($nosotros, $richTextFilter) {
            HtmlGen::div(array('class' => 'modal-content'), function () use ($nosotros, $richTextFilter) {
                HtmlGen::div(array('class' => 'modal-header'), function () {
                    HtmlGen::button(array(
                        'type' => 'button',
                        'class' => 'close',
                        'data-dismiss' => 'modal',
                        'aria-label' => 'Cerrar'
                    ), function () {
                        HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                    });
                    HtmlGen::h3(array('class' => 'modal-title'), 'Perfil Profesional');
                });
                HtmlGen::div(array('class' => 'modal-body'), function () use ($nosotros, $richTextFilter) {
                    HtmlGen::div(array('class' => 'text-justify'), $richTextFilter->purify($nosotros['PerfilProfesional']));
                });
            });
        });
    });

    // Cuadro de diálogo Campo Ocupacional
    HtmlGen::comment('Cuadro de diálogo Campo Ocupacional');
    HtmlGen::div(array(
        'class' => 'modal fade',
        'id' => 'campo-ocupacional',
        'tabindex' => '-1',
        'role' => 'dialog'
    ), function () use ($nosotros, $richTextFilter) {
        HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($nosotros, $richTextFilter) {
            HtmlGen::div(array('class' => 'modal-content'), function () use ($nosotros, $richTextFilter) {
                HtmlGen::div(array('class' => 'modal-header'), function () {
                    HtmlGen::button(array(
                        'type' => 'button',
                        'class' => 'close',
                        'data-dismiss' => 'modal',
                        'aria-label' => 'Cerrar'
                    ), function () {
                        HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                    });
                    HtmlGen::h3(array('class' => 'modal-title'), 'Campo Ocupacional');
                });
                HtmlGen::div(array('class' => 'modal-body'), function () use ($nosotros, $richTextFilter) {
                    HtmlGen::div(array('class' => 'text-justify'), $richTextFilter->purify($nosotros['CampoOcupacional']));
                });
            });
        });
    });

    // Cuadro de diálogo Grados y Títulos
    HtmlGen::comment('Cuadro de diálogo Grados y Títulos');
    HtmlGen::div(array(
        'class' => 'modal fade',
        'id' => 'grados-titulos',
        'tabindex' => '-1',
        'role' => 'dialog'
    ), function () use ($nosotros, $plainTextFilter) {
        HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($nosotros, $plainTextFilter) {
            HtmlGen::div(array('class' => 'modal-content'), function () use ($nosotros, $plainTextFilter) {
                HtmlGen::div(array('class' => 'modal-header'), function () {
                    HtmlGen::button(array(
                        'type' => 'button',
                        'class' => 'close',
                        'data-dismiss' => 'modal',
                        'aria-label' => 'Cerrar'
                    ), function () {
                        HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                    });
                    HtmlGen::h3(array('class' => 'modal-title'), 'Grados y Títulos');
                });
                HtmlGen::div(array('class' => 'modal-body'), function () use ($nosotros, $plainTextFilter) {
                    HtmlGen::dl(function () use ($nosotros, $plainTextFilter) {
                        HtmlGen::dt('Grado académico');
                        HtmlGen::dd($plainTextFilter->purify($nosotros['GradoAcademico']));
                        HtmlGen::dt('Título profesional');
                        HtmlGen::dd($plainTextFilter->purify($nosotros['TituloProfesional']));
                    });
                });
            });
        });
    });

    // Cuadro de diálogo Objetivos curriculares
    HtmlGen::comment('Cuadro de diálogo Objetivos curriculares');
    HtmlGen::div(array(
        'class' => 'modal fade',
        'id' => 'objetivos-curriculares',
        'tabindex' => '-1',
        'role' => 'dialog'
    ), function () use ($plan_estudios, $richTextFilter) {
        HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($plan_estudios, $richTextFilter) {
            HtmlGen::div(array('class' => 'modal-content'), function () use ($plan_estudios, $richTextFilter) {
                HtmlGen::div(array('class' => 'modal-header'), function () {
                    HtmlGen::button(array(
                        'type' => 'button',
                        'class' => 'close',
                        'data-dismiss' => 'modal',
                        'aria-label' => 'Cerrar'
                    ), function () {
                        HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                    });
                    HtmlGen::h3(array('class' => 'modal-title'), 'Objetivos curriculares');
                });
                HtmlGen::div(array('class' => 'modal-body'), function () use ($plan_estudios, $richTextFilter) {
                    HtmlGen::div(array('class' => 'text-justify'), $richTextFilter->purify($plan_estudios['ObjetivosCurriculares']));
                });
            });
        });
    });

    // Cuadro de diálogo Objetivo general
    HtmlGen::comment('Cuadro de diálogo Objetivo general');
    HtmlGen::div(array(
        'class' => 'modal fade',
        'id' => 'objetivo-general',
        'tabindex' => '-1',
        'role' => 'dialog'
    ), function () use ($plan_estudios, $richTextFilter) {
        HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($plan_estudios, $richTextFilter) {
            HtmlGen::div(array('class' => 'modal-content'), function () use ($plan_estudios, $richTextFilter) {
                HtmlGen::div(array('class' => 'modal-header'), function () {
                    HtmlGen::button(array(
                        'type' => 'button',
                        'class' => 'close',
                        'data-dismiss' => 'modal',
                        'aria-label' => 'Cerrar'
                    ), function () {
                        HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                    });
                    HtmlGen::h3(array('class' => 'modal-title'), 'Objetivo general');
                });
                HtmlGen::div(array('class' => 'modal-body'), function () use ($plan_estudios, $richTextFilter) {
                    HtmlGen::div(array('class' => 'text-justify'), $richTextFilter->purify($plan_estudios['ObjetivoGeneral']));
                });
            });
        });
    });

    // Cuadro de diálogo Objetivos específicos
    HtmlGen::comment('Cuadro de diálogo Objetivos específicos');
    HtmlGen::div(array(
        'class' => 'modal fade',
        'id' => 'objetivos-especificos',
        'tabindex' => '-1',
        'role' => 'dialog'
    ), function () use ($plan_estudios, $richTextFilter) {
        HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($plan_estudios, $richTextFilter) {
            HtmlGen::div(array('class' => 'modal-content'), function () use ($plan_estudios, $richTextFilter) {
                HtmlGen::div(array('class' => 'modal-header'), function () {
                    HtmlGen::button(array(
                        'type' => 'button',
                        'class' => 'close',
                        'data-dismiss' => 'modal',
                        'aria-label' => 'Cerrar'
                    ), function () {
                        HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                    });
                    HtmlGen::h3(array('class' => 'modal-title'), 'Objetivos específicos');
                });
                HtmlGen::div(array('class' => 'modal-body'), function () use ($plan_estudios, $richTextFilter) {
                    HtmlGen::div(array('class' => 'text-justify'), $richTextFilter->purify($plan_estudios['ObjetivosEspecificos']));
                });
            });
        });
    });

    // Cuadro de diálogo Objetivos de formación básica
    HtmlGen::comment('Cuadro de diálogo Objetivos de formación básica');
    HtmlGen::div(array(
        'class' => 'modal fade',
        'id' => 'objetivos-formacion-basica',
        'tabindex' => '-1',
        'role' => 'dialog'
    ), function () use ($plan_estudios, $richTextFilter) {
        HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($plan_estudios, $richTextFilter) {
            HtmlGen::div(array('class' => 'modal-content'), function () use ($plan_estudios, $richTextFilter) {
                HtmlGen::div(array('class' => 'modal-header'), function () {
                    HtmlGen::button(array(
                        'type' => 'button',
                        'class' => 'close',
                        'data-dismiss' => 'modal',
                        'aria-label' => 'Cerrar'
                    ), function () {
                        HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                    });
                    HtmlGen::h3(array('class' => 'modal-title'), 'Objetivos de formación básica');
                });
                HtmlGen::div(array('class' => 'modal-body'), function () use ($plan_estudios, $richTextFilter) {
                    HtmlGen::div(array('class' => 'text-justify'), $richTextFilter->purify($plan_estudios['ObjetivosFormacionBasica']));
                });
            });
        });
    });

    // Cuadro de diálogo Objetivos de formación profesional
    HtmlGen::comment('Cuadro de diálogo Objetivos de formación profesional');
    HtmlGen::div(array(
        'class' => 'modal fade',
        'id' => 'objetivos-formacion-profesional',
        'tabindex' => '-1',
        'role' => 'dialog'
    ), function () use ($plan_estudios, $richTextFilter) {
        HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($plan_estudios, $richTextFilter) {
            HtmlGen::div(array('class' => 'modal-content'), function () use ($plan_estudios, $richTextFilter) {
                HtmlGen::div(array('class' => 'modal-header'), function () {
                    HtmlGen::button(array(
                        'type' => 'button',
                        'class' => 'close',
                        'data-dismiss' => 'modal',
                        'aria-label' => 'Cerrar'
                    ), function () {
                        HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                    });
                    HtmlGen::h3(array('class' => 'modal-title'), 'Objetivos de formación profesional');
                });
                HtmlGen::div(array('class' => 'modal-body'), function () use ($plan_estudios, $richTextFilter) {
                    HtmlGen::div(array('class' => 'text-justify'), $richTextFilter->purify($plan_estudios['ObjetivosFormacionProfesional']));
                });
            });
        });
    });

    // Cuadro de diálogo Plan de estudios general
    HtmlGen::comment('Cuadro de diálogo Plan de estudios general');
    HtmlGen::div(array(
        'class' => 'modal fade',
        'id' => 'plan-estudios-general',
        'tabindex' => '-1',
        'role' => 'dialog'
    ), function () use ($plan_estudios, $richTextFilter) {
        HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($plan_estudios, $richTextFilter) {
            HtmlGen::div(array('class' => 'modal-content'), function () use ($plan_estudios, $richTextFilter) {
                HtmlGen::div(array('class' => 'modal-header'), function () {
                    HtmlGen::button(array(
                        'type' => 'button',
                        'class' => 'close',
                        'data-dismiss' => 'modal',
                        'aria-label' => 'Cerrar'
                    ), function () {
                        HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                    });
                    HtmlGen::h3(array('class' => 'modal-title'), 'Plan de estudios general');
                });
                HtmlGen::div(array('class' => 'modal-body'), function () use ($plan_estudios, $richTextFilter) {
                    HtmlGen::div(array('class' => 'text-justify'), $richTextFilter->purify($plan_estudios['PlanEstudiosGeneral']));
                });
            });
        });
    });

    // Cuadro de diálogo Plan de estudios específico y de especialidad
    HtmlGen::comment('Cuadro de diálogo Plan de estudios específico y de especialidad');
    HtmlGen::div(array(
        'class' => 'modal fade',
        'id' => 'plan-estudios-especifico-especialidad',
        'tabindex' => '-1',
        'role' => 'dialog'
    ), function () use ($plan_estudios, $richTextFilter) {
        HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($plan_estudios, $richTextFilter) {
            HtmlGen::div(array('class' => 'modal-content'), function () use ($plan_estudios, $richTextFilter) {
                HtmlGen::div(array('class' => 'modal-header'), function () {
                    HtmlGen::button(array(
                        'type' => 'button',
                        'class' => 'close',
                        'data-dismiss' => 'modal',
                        'aria-label' => 'Cerrar'
                    ), function () {
                        HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                    });
                    HtmlGen::h3(array('class' => 'modal-title'), 'Plan de estudios específico y de especialidad');
                });
                HtmlGen::div(array('class' => 'modal-body'), function () use ($plan_estudios, $richTextFilter) {
                    HtmlGen::div(array('class' => 'text-justify'), $richTextFilter->purify($plan_estudios['PlanEstudiosEspecificoEspecialidad']));
                });
            });
        });
    });

    // Cuadro de diálogo Plan de estudios semestralizado
    HtmlGen::comment('Cuadro de diálogo Plan de estudios semestralizado');
    HtmlGen::div(array(
        'class' => 'modal fade',
        'id' => 'plan-estudios-semestralizado',
        'tabindex' => '-1',
        'role' => 'dialog'
    ), function () use ($plan_estudios, $richTextFilter) {
        HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($plan_estudios, $richTextFilter) {
            HtmlGen::div(array('class' => 'modal-content'), function () use ($plan_estudios, $richTextFilter) {
                HtmlGen::div(array('class' => 'modal-header'), function () {
                    HtmlGen::button(array(
                        'type' => 'button',
                        'class' => 'close',
                        'data-dismiss' => 'modal',
                        'aria-label' => 'Cerrar'
                    ), function () {
                        HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                    });
                    HtmlGen::h3(array('class' => 'modal-title'), 'Plan de estudios semestralizado');
                });
                HtmlGen::div(array('class' => 'modal-body'), function () use ($plan_estudios, $richTextFilter) {
                    HtmlGen::div(array('class' => 'text-justify'), $richTextFilter->purify($plan_estudios['PlanEstudiosSemestralizado']));
                });
            });
        });
    });

    // Cuadro de diálogo Plana Docente
    if (count($lista_docentes) > 6) {
        HtmlGen::comment('Cuadro de diálogo Plana Docente');
        HtmlGen::div(array(
            'class' => 'modal fade',
            'id' => 'plana-docente',
            'tabindex' => '-1',
            'role' => 'dialog'
        ), function () use ($lista_docentes, $plainTextFilter) {
            HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($lista_docentes, $plainTextFilter) {
                HtmlGen::div(array('class' => 'modal-content'), function () use ($lista_docentes, $plainTextFilter) {
                    HtmlGen::div(array('class' => 'modal-header'), function () {
                        HtmlGen::button(array(
                            'type' => 'button',
                            'class' => 'close',
                            'data-dismiss' => 'modal',
                            'aria-label' => 'Cerrar'
                        ), function () {
                            HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                        });
                        HtmlGen::h3(array('class' => 'modal-title'), 'Plana Docente');
                    });
                    HtmlGen::div(array('class' => 'modal-body has-loader'), function () use ($lista_docentes, $plainTextFilter) {
                        HtmlGen::div(array('class' => 'table-responsive'), function () use ($lista_docentes, $plainTextFilter) {
                            HtmlGen::table(array('class' => 'table table-hover'), function () use ($lista_docentes, $plainTextFilter) {
                                HtmlGen::tr(function () {
                                    HtmlGen::th(array('colspan' => '2'), 'Docente');
                                    HtmlGen::th('Grado académico');
                                    HtmlGen::th('Categoría y regimen');
                                    HtmlGen::th(array('class' => 'text-center'), 'Recursos');
                                });

                                foreach ($lista_docentes as $docente) {
                                    // Construye la ruta del archivo correspondiente a la fotografía del docente
                                    $archivo = join_paths(STORAGE_PATH, 'docentes', $docente['TokenImagen'] . '.jpg');

                                    // Verifica si no existe el archivo en la ruta obtenida
                                    if (!file_exists($archivo)) {
                                        // Obtiene el URL de la imagen alternativa de contingencia
                                        $url_imagen = '../images/portrait-thumbnail-placeholder.png';
                                    }
                                    else {
                                        // Obtiene el URL de la imagen
                                        $url_imagen = '../storage/docentes/' . $docente['TokenImagen'] . '.jpg';
                                    }

                                    HtmlGen::tr(function () use ($docente, $url_imagen, $plainTextFilter) {
                                        HtmlGen::td(array('class' => 'col-xs-1'), function () use ($url_imagen) {
                                            HtmlGen::img(array(
                                                'class' => 'img-circle',
                                                'src' => $url_imagen,
                                                'alt' => 'Foto'
                                            ));
                                        });
                                        HtmlGen::td($plainTextFilter->purify($docente['Nombre']));
                                        HtmlGen::td($plainTextFilter->purify($docente['GradoAcademico']));
                                        HtmlGen::td($plainTextFilter->purify($docente['CategoriaRegimen']));
                                        HtmlGen::td(array('class' => 'text-center'), function () use ($docente, $plainTextFilter) {
                                            HtmlGen::a(function () {
                                                HtmlGen::i(array('class' => 'fa fa-envelope-o fa-fw'));
                                            }, 'mailto:' . $plainTextFilter->purify($docente['CorreoElectronico']), array(
                                                'title' => 'Correo electrónico',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top'
                                            ));

                                            if (!empty($docente['HojaVida'])) {
                                                HtmlGen::a(function () {
                                                    HtmlGen::i(array('class' => 'fa fa-file-text-o fa-fw'));
                                                }, $plainTextFilter->purify($docente['HojaVida']), array(
                                                    'target' => '_blank',
                                                    'title' => 'Hoja de vida',
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => 'top'
                                                ));
                                            }
                                            else {
                                                HtmlGen::i(array(
                                                    'class' => 'fa fa-file-text-o fa-fw text-muted',
                                                    'title' => 'Hoja de vida',
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => 'top'
                                                ));
                                            }
                                        });
                                    });
                                }
                            });
                        });
                    });
                });
            });
        });
    }

    // Cuacro de diálogo Publicación
    if (count($publicaciones_destacadas) + count($publicaciones_no_destacadas) > 0) {
        HtmlGen::comment('Cuacro de diálogo Publicación');
        HtmlGen::div(array(
            'class' => 'modal fade',
            'id' => 'publicacion',
            'tabindex' => '-1',
            'role' => 'dialog'
        ), function () {
            HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () {
                HtmlGen::div(array('class' => 'modal-content'), function () {
                    HtmlGen::div(array('class' => 'modal-header'), function () {
                        HtmlGen::button(array(
                            'type' => 'button',
                            'class' => 'close',
                            'data-dismiss' => 'modal',
                            'aria-label' => 'Cerrar'
                        ), function () {
                            HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                        });
                        HtmlGen::h3(array('class' => 'modal-title'), 'Noticias');
                    });
                    HtmlGen::div(array('class' => 'modal-body has-loader'), function () {
                        HtmlGen::div(array('class' => 'publishing-container'));
                    });
                });
            });
        });
    }
    
    // Cuadro de diálogo Descargas
    if (count($lista_documentos) > 6) {
        HtmlGen::comment('Cuadro de diálogo Descargas');
        HtmlGen::div(array(
            'class' => 'modal fade',
            'id' => 'lista-descargas',
            'tabindex' => '-1',
            'role' => 'dialog'
        ), function () use ($lista_documentos, $plainTextFilter) {
            HtmlGen::div(array('class' => 'modal-dialog modal-lg modal-vertical-scroll'), function () use ($lista_documentos, $plainTextFilter) {
                HtmlGen::div(array('class' => 'modal-content'), function () use ($lista_documentos, $plainTextFilter) {
                    HtmlGen::div(array('class' => 'modal-header'), function () {
                        HtmlGen::button(array(
                            'type' => 'button',
                            'class' => 'close',
                            'data-dismiss' => 'modal',
                            'aria-label' => 'Cerrar'
                        ), function () {
                            HtmlGen::span(array('aria-hidden' => 'true'), '&times;');
                        });
                        HtmlGen::h3(array('class' => 'modal-title'), 'Descargas');
                    });
                    HtmlGen::div(array('class' => 'modal-body'), function () use ($lista_documentos, $plainTextFilter) {
                        HtmlGen::table(array('class' => 'table table-hover'), function () use ($lista_documentos, $plainTextFilter) {
                            HtmlGen::tr(function () {
                                HtmlGen::th(array(
                                    'class' => 'text-center',
                                    'colspan' => '2'
                                ), 'Descripción');
                                HtmlGen::th(array('class' => 'text-center col-xs-1'), 'Fecha de publicación');
                                HtmlGen::th(array('class' => 'text-center col-xs-1'), 'Tamaño');
                            });

                            foreach ($lista_documentos as $documento) {
                                // Constrye la ruta del documento
                                $archivo = join_paths(STORAGE_PATH, 'documentos', $documento['TokenDocumento'] . '.pdf');
                                // Calcula el tamaño del archivo
                                $tamano = formatted_filesize($archivo);
                                // Obtiene la fecha de publicación en formato corto
                                $fecha = formatted_datetime($documento['FechaHoraPublicacion']);

                                HtmlGen::tr(array(
                                    'class' => 'file-row',
                                    'data-href' => 'documento.php?uid=' . $documento['TokenDocumento'] . '&filename=' . urlencode($plainTextFilter->purify($documento['Descripcion']))
                                ), function () use ($documento, $tamano, $fecha, $plainTextFilter) {
                                    HtmlGen::td(function () {
                                        HtmlGen::img(array(
                                            'src' => BASE_URL . '/images/pdf-small.png',
                                            'alt' => 'Icono'
                                        ));
                                    });
                                    HtmlGen::td($plainTextFilter->purify($documento['Descripcion']));
                                    HtmlGen::td($fecha);
                                    HtmlGen::td($tamano);
                                });
                            }
                        });
                    });
                });
            });
        });
    }
?>