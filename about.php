<?php
require_once 'includes/functions.php';

get_header('À propos', 'Découvrez l\'histoire de Baby Planner Douceur et notre passion pour organiser vos moments précieux');
?>

<main>
    <section class="about-header">
        <div class="container">
            <h1>À propos de nous</h1>
            <p>La passion de créer des moments inoubliables pour votre famille</p>
        </div>
    </section>

    <section class="about-story">
        <div class="container">
            <div class="story-content">
                <div class="story-text">
                    <h2>Notre histoire</h2>
                    <p>
                        Baby Planner Douceur est née de l'envie de rendre chaque moment de votre parcours de parentalité absolument magique. 
                        Forte de plusieurs années d'expérience dans l'événementiel et la décoration, j'ai décidé de me spécialiser dans 
                        l'accompagnement des futurs et nouveaux parents.
                    </p>
                    <p>
                        Chaque projet est unique, à l'image de votre famille. Mon approche personnalisée me permet de créer des événements 
                        qui vous ressemblent, dans le respect de vos goûts, de votre budget et de vos attentes.
                    </p>
                </div>
                <div class="story-image">
                    <div class="image-placeholder">
                        <span class="placeholder-icon">👶</span>
                        <p>Photo de l'équipe</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-values">
        <div class="container">
            <h2>Nos valeurs</h2>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">💝</div>
                    <h3>Personnalisation</h3>
                    <p>Chaque événement est conçu sur-mesure selon vos goûts, votre style et vos envies particulières.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">⭐</div>
                    <h3>Excellence</h3>
                    <p>Nous sélectionnons les meilleurs prestataires et matériaux pour garantir la qualité de votre événement.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">🤗</div>
                    <h3>Bienveillance</h3>
                    <p>Nous vous accompagnons avec douceur et compréhension dans ces moments si précieux de votre vie.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">✨</div>
                    <h3>Créativité</h3>
                    <p>Des idées originales et des concepts innovants pour rendre votre événement vraiment unique.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="about-process">
        <div class="container">
            <h2>Notre méthode</h2>
            <div class="process-timeline">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Consultation gratuite</h3>
                        <p>Nous définissons ensemble vos besoins, envies et budget lors d'un premier échange de 30 minutes.</p>
                    </div>
                </div>
                
                <div class="process-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Création du concept</h3>
                        <p>Je conçois un concept personnalisé avec mood board, planning détaillé et devis transparent.</p>
                    </div>
                </div>
                
                <div class="process-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Organisation complète</h3>
                        <p>Je m'occupe de tous les détails : prestataires, décoration, logistique et coordination le jour J.</p>
                    </div>
                </div>
                
                <div class="process-step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Votre moment magique</h3>
                        <p>Profitez pleinement de votre événement pendant que je veille au bon déroulement de chaque instant.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Prête à créer des souvenirs inoubliables ?</h2>
                <p>Parlons de votre projet lors d'une consultation gratuite et sans engagement</p>
                <div class="cta-actions">
                    <a href="contact.php" class="btn btn-primary">
                        📞 Consultation gratuite
                    </a>
                    <a href="services.php" class="btn btn-outline">
                        ✨ Voir nos services
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.about-header {
    padding: 120px 0 60px;
    background: linear-gradient(135deg, var(--violet-pale), var(--violet-light));
    text-align: center;
}

.about-header h1 {
    font-size: 2.5rem;
    color: var(--violet-dark);
    margin-bottom: 1rem;
}

.about-story {
    padding: 4rem 0;
}

.story-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: center;
}

.story-text h2 {
    color: var(--violet-dark);
    margin-bottom: 1.5rem;
}

.story-text p {
    margin-bottom: 1.5rem;
    line-height: 1.7;
    font-size: 1.1rem;
}

.image-placeholder {
    background: var(--violet-pale);
    border-radius: var(--border-radius);
    padding: 3rem;
    text-align: center;
    border: 2px dashed var(--violet-light);
}

.placeholder-icon {
    font-size: 4rem;
    display: block;
    margin-bottom: 1rem;
}

.about-values {
    padding: 4rem 0;
    background: var(--violet-pale);
}

.about-values h2 {
    text-align: center;
    color: var(--violet-dark);
    margin-bottom: 3rem;
    font-size: 2.2rem;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.value-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    text-align: center;
    transition: var(--transition);
}

.value-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
}

.value-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.value-card h3 {
    color: var(--violet-dark);
    margin-bottom: 1rem;
}

.about-process {
    padding: 4rem 0;
}

.about-process h2 {
    text-align: center;
    color: var(--violet-dark);
    margin-bottom: 3rem;
    font-size: 2.2rem;
}

.process-timeline {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    max-width: 800px;
    margin: 0 auto;
}

.process-step {
    display: flex;
    align-items: flex-start;
    gap: 2rem;
    padding: 2rem;
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    position: relative;
}

.process-step:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 35px;
    bottom: -2rem;
    width: 2px;
    height: 2rem;
    background: var(--violet-light);
}

.step-number {
    background: var(--violet-primary);
    color: var(--white);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.step-content h3 {
    color: var(--violet-dark);
    margin-bottom: 0.5rem;
}

.step-content p {
    color: #666;
    line-height: 1.6;
}

.about-cta {
    padding: 4rem 0;
    background: linear-gradient(135deg, var(--violet-primary), var(--violet-dark));
    color: var(--white);
    text-align: center;
}

.about-cta h2 {
    color: var(--white);
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.about-cta p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.cta-actions {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .story-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .process-timeline {
        padding: 0 1rem;
    }
    
    .process-step {
        flex-direction: column;
        text-align: center;
    }
    
    .process-step::after {
        left: 50%;
        transform: translateX(-50%);
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<?php get_footer(); ?>
